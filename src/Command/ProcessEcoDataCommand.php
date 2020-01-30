<?php


namespace App\Command;

use App\Entity\Buy;
use App\Entity\Craft;
use App\Entity\Harvest;
use App\Entity\Pickup;
use App\Entity\Place;
use App\Entity\Play;
use App\Entity\Sell;
use App\Entity\Server;
use App\Entity\User;
use App\Service\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProcessEcoDataCommand
 * @example php bin/console eco:data:process
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class ProcessEcoDataCommand extends Command
{
    public const COMMAND_NAME = 'eco:data:process';

    /** @var EntityManagerInterface */
    private $em;

    /** @var LoggerInterface */
    private $logger;

    /** @var string */
    private $eco_data_folder;

    /** @var OutputInterface */
    private $output;

    /** @var EntityService */
    private $entity_service;

    public function __construct(
        EntityManagerInterface $entity_manager, LoggerInterface $eco_process_logger, EntityService $entity_service, string $eco_data_folder
    ) {
        $this->em = $entity_manager;
        $this->logger = $eco_process_logger;
        $this->eco_data_folder = $eco_data_folder;
        $this->entity_service = $entity_service;

        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure()
    {
        $this
            ->setDescription('Process eco data received from webhook')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $files = array_filter(
            scandir($this->eco_data_folder),
            function($value) {
                return $value !== '.' && $value !== '..' && strpos($value, '.json');
            }
        );

        foreach($files as $file_name)
        {
            $this->log(sprintf('processing file: %s', $file_name));
            $file_path = $this->eco_data_folder . "/" . $file_name;

            // process file content
            $collections = file_get_contents($file_path);
            $collections = json_decode($collections, true); // overwrite raw data to save memory

            foreach($collections as $collection => $data)
            {
                if (count($data) === 0)
                {
                    $this->log(sprintf('%s is empty', $collection));
                    continue;
                }

                // get entity class
                $entity_class = EntityService::chooseEntityClass($collection);
                if (!$entity_class)
                {
                    $this->log(sprintf('%s not found or implemented', $collection));
                    continue;
                }

                // if there has been a reset, delete all records >= _id
                $repo = $this->em->getRepository($entity_class);
                /** @var Pickup[] $last_record */
                $last_record = $repo->findBy([],['_id'=>'DESC'],1,0);
                if ($last_record[0]->getExternalId() > $data[0]['_id'])
                {
                    $this->log('there has been a reset');
                    $repo->deleteAllHigherThanId($data[0]['_id']);
                }

                $limit = 250;
                while(count($data) > 0) {
                    // while loop
                    $spliced_data = array_splice($data, 0, $limit);
                    foreach ($spliced_data as $class_data)
                    {
                        $this->entity_service->createEntity($entity_class, $class_data);
                    }
                    $this->em->flush();
                    $this->em->clear();
                }

                // if sale or buy is the last in the data array, finish the last sale/buy
                $this->entity_service->finishStackedData();
            }

            unlink($file_path);
        }

        /** @var Server $server */
        $server = $this->em->getRepository(Server::class)->findOneBy(['name' => Server::SERVER_NAME]);
        $server->setLastProcess(new \DateTime());
        $this->em->flush();

        return 0;
    }

    private function log(string $message)
    {
        $this->output->writeln($message);
        $this->logger->info($message, [
            'allocated' => sprintf('%d KB', (memory_get_peak_usage() / 1024)),
            'real_usage' => sprintf('%d KB', (memory_get_peak_usage(true) / 1024)),
        ]);
    }
}
