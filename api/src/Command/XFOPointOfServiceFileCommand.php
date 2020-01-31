<?php

namespace App\Command\FuelOffice;

use App\Command\BaseCommand;
use App\DTO\Validation\FuelOffice\PointOfService\PointOfServiceXFODTO;
use App\Entity\AllowedCardCode;
use App\Entity\Organization;
use App\Entity\PointOfService;
use App\Form\Validation\FuelOffice\PointOfService\PointOfServiceXFODTOType;
use App\Service\PointOfServiceService;
use App\Service\Traits\SearchTrait;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class XFOPointOfServiceFileCommand.
 *
 * @example php bin/console xfo:point-of-service:file point_of_service-2020-01-13T11:39:24.json 1
 *
 * @author  Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class XFOPointOfServiceFileCommand extends BaseCommand
{
    use SearchTrait;

    public const COMMAND_NAME = 'xfo:point-of-service:file';

    /** @var EntityManagerInterface */
    private $em;

    /** @var LoggerInterface */
    private $logger;

    /** @var FormFactory */
    private $form_factory;

    /** @var PointOfServiceService */
    private $point_of_service_service;

    /** @var string */
    private $xfo_temp_folder;

    public function __construct(
        EntityManagerInterface $entity_manager, LoggerInterface $logger, FormFactoryInterface $form_factory,
        PointOfServiceService $point_of_service_service, string $xfo_temp_folder
    ) {
        $this->em = $entity_manager;
        $this->logger = $logger;
        $this->point_of_service_service = $point_of_service_service;
        $this->xfo_temp_folder = $xfo_temp_folder;
        $this->form_factory = $form_factory;

        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure()
    {
        $this
            ->setDescription('Import point of services from Fuel Office')
            ->addArgument('file', InputArgument::REQUIRED, 'The file name that needs to be imported')
            ->addArgument('organization', InputArgument::REQUIRED, 'The organization for which to process the point of services')
            ->addOption('mutation', 'm', InputOption::VALUE_OPTIONAL, 'If true; locations not given won\'t get put on inactive')
            ->addOption('delete', 'd', InputOption::VALUE_OPTIONAL, 'Delete the file at the end.')
        ;
    }

    /**
     * @return int|void|null
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $organization_id = $input->getArgument('organization');
        $file_name = $input->getArgument('file');
        $file_path = $this->xfo_temp_folder . $file_name;
        if (!file_exists(realpath($file_path)))
        {
            throw new InvalidArgumentException('File not found');
        }

        $data = file_get_contents($file_path);
        $data = json_decode($data, true); // overwrite raw data to save memory
        if (!$data)
        {
            $this->handleError($file_name);
        }

        $progress_bar = new ProgressBar($output, count($data));

        $limit = 250;
        $offset = 0;
        $errors = [];
        $all_ids = [];
        $organization = null;
        $valid_counter = 0;
        $has_next_batch = true;
        while (true === $has_next_batch)
        {
            // get it every x times because of $em->clear()
            $organization = $this->em->getRepository(Organization::class)->find($organization_id);
            if (!$organization)
            {
                throw new InvalidArgumentException('Could not find organization');
            }

            // DTO & Form Validation.
            $ids = [];
            $valid_items = [];
            $spliced_data = array_splice($data, 0, $limit);
            foreach ($spliced_data as $item)
            {
                $progress_bar->advance();

                $form = $this->form_factory->create(PointOfServiceXFODTOType::class);
                $form->submit($item, false);
                if (!$form->isSubmitted() || !$form->isValid())
                {
                    $errors[$item['id']] = $this->getFormErrors($form);
                    continue;
                }

                /** @var PointOfServiceXFODTO $item */
                $item = $form->getData();
                $valid_items[] = $item;
                $all_ids[] = $item->id;
                $ids[] = $item->id;
            }

            /** @var PointOfService[] $point_of_services */
            $point_of_services = $this->em->getRepository(PointOfService::class)->findAllByXFOIds($organization, $ids);

            // create / get allowed_card_codes
            // this array is temporary untill this is implemented in spin, if this is changed; update as well in PointOfServiceServe:119
            $allowed_card_codes = [
                '450' => 'AdBlue',
                '530' => 'Aardgas',
                '425' => 'Diesel',
                '325' => 'NormalUnleaded',
                '525' => 'LiquefiedPetroleumGas',
                '13376969' => 'Blauwe Diesel 100',
            ];

            // get all existing allowed_card_codes based on unique allowed_card_codes
            $existing_allowed_card_codes = $this->em->getRepository(AllowedCardCode::class)->findAllByTypes($allowed_card_codes);

            $new_allowed_card_codes = array_diff_key($allowed_card_codes, $existing_allowed_card_codes);
            if (count($new_allowed_card_codes) > 0)
            {
                foreach ($new_allowed_card_codes as $card_code => $new_allowed_card_code)
                {
                    $allowed_card_code = new AllowedCardCode(
                        $new_allowed_card_code,
                        $card_code,
                        AllowedCardCode::TSG_TYPE
                    );
                    $this->em->persist($allowed_card_code);
                    $existing_allowed_card_codes[] = $allowed_card_code;
                }
                $this->em->flush();
            }

            /** @var PointOfServiceXFODTO $item */
            foreach ($valid_items as $item)
            {
                /** @var PointOfService $point_of_service */
                $point_of_service = $this->entityArraySearch($point_of_services, 'getXfoId', $item->id);
                if (!$point_of_service)
                {
                    //create & persist new entities
                    $this->point_of_service_service->createFuelOfficePointOfServiceFromDTO($item, $organization, $existing_allowed_card_codes);
                }
                else
                {
                    //update all the entities
                    $this->point_of_service_service->updateFuelOfficePointOfServiceFromDTO($point_of_service, $item, $existing_allowed_card_codes);
                }
            }

            try
            {
                $this->em->flush();
                $this->em->clear();
            }
            catch (Exception $exception)
            {
                $this->handleError($file_name);
            }

            if (0 === count($data))
            {
                $has_next_batch = false;
            }

            $valid_counter += count($valid_items);
            $offset += $limit;
        }

        // get all not in ids and put on inactive
        if (!$input->getOption('mutation'))
        {
            if (!$organization)
            {
                throw new InvalidArgumentException('no organization found');
            }

            $point_of_services = $this->em->getRepository(PointOfService::class)->findAllNotInArray($organization, $all_ids);
            foreach ($point_of_services as $point_of_service)
            {
                $point_of_service->setAvailable(false);
            }
            $this->em->flush();
        }

        if (count($errors) > 0)
        {
            $this->logger->error(sprintf('%d locations couldn\'t be parsed', count($errors)), $errors);
            $this->handleError($file_name);
        }
        elseif ($input->getOption('delete'))
        {
            unlink($file_path);
        }

        $progress_bar->finish();
        $output->write(sprintf('Processed %d XFO points of services for organization_id: %d.', $valid_counter, $organization->getId()));
    }

    /**
     * @throws Exception
     */
    private function handleError(string $file_name)
    {
        // move file to error folder
        if (!rename(
            $this->xfo_temp_folder . $file_name,
            sprintf('%serrors/%s', $this->xfo_temp_folder, $file_name)
        ))
        {
            throw new Exception(sprintf('Could not move file to error location: %s', $file_name));
        }

        throw new InvalidArgumentException(sprintf('XFO: Could not import the point of services from %s', $file_name));
    }
}
