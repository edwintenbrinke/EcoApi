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
use App\Service\EntityService;
use App\Service\ProcessModDataService;
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
 * @example php bin/console eco:mod:process
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class ProcessEcoModDataCommand extends Command
{
    public const COMMAND_NAME = 'eco:mod:process';

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

    /** @var ProcessModDataService */
    private $mod_data_service;

    public function __construct(
        EntityManagerInterface $entity_manager, LoggerInterface $eco_process_mod_data_logger, EntityService $entity_service,
        ProcessModDataService $mod_data_service, string $eco_mod_data_folder
    ) {
        $this->em = $entity_manager;
        $this->logger = $eco_process_mod_data_logger;
        $this->eco_data_folder = $eco_mod_data_folder;
        $this->mod_data_service = $mod_data_service;
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
            $content = json_decode($collections, true);
            if (!is_array($content)) $content = [];
            foreach($content as $collection)
            {
                if (array_key_exists('server', $collection))
                {
                    $this->mod_data_service->processServerData($collection['server']);
                }
                elseif (array_key_exists('users', $collection))
                {
                    $this->mod_data_service->processUserData($collection['users']);
                }
            }

            unlink($file_path);
        }

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
