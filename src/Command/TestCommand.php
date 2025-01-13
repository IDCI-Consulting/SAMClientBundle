<?php

namespace IDCI\Bundle\SAMClientBundle\Command;

use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealProgress;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    private SAMApiClient $client;

    public function __construct(SAMApiClient $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    protected function configure(): void
    {
        $this
            ->setName('sam:test')
            ->setDescription('Command for testing API calls')
            // ->addArgument('externalId', null, InputArgument::REQUIRED, '')
            // ->addArgument('partnerReference', null, InputArgument::REQUIRED, '')
            // ->addArgument('brandReference', null, InputArgument::REQUIRED, '')
            // ->addOption('internal-number', null, InputOption::VALUE_REQUIRED, '')
            // ->addOption('employee-code', null, InputOption::VALUE_REQUIRED, '')
            // ->addOption('date', null, InputOption::VALUE_REQUIRED, '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // id : 20277
        try {
            // $samResponse = $this->client->getBusinessDeal(20277);

            $samResponse = $this->client->createBusinessDeal([
                'externalId' => 'Test2',
                'partnerReference' => 'FR center',
                'brandReference' => 'Brand 002'
                // 'progress' => (new BusinessDealProgress())->setReceptionDate('2024-01-01')
            ]);

            // $samResponse = $this->client->updateActivityByInternalNumber('testId', 'A020', [
            //     'status' => 'started'
            // ]);

            dd($samResponse);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>SAM API could not respond : "%s"</error>', $e->getMessage()));

            return Command::FAILURE;
        }
    }
}
