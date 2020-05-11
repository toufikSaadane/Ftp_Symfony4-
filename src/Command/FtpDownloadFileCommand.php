<?php

namespace App\Command;

use App\Services\FtpConnection\FtpService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FtpDownloadFileCommand extends Command
{
    /**
     * @var FtpService
     */
    private $ftpService;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(string $name=null, FtpService $ftpService, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->ftpService=$ftpService;
        $this->container=$container;
    }

    protected static $defaultName = 'ftp:downloadFile';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $local_file = "Berth.xml";
        $dis = $this->container->getParameter('files')."$local_file";
//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
         if ($this->ftpService->downloadFtp($dis)){
             printf("===================download %s, is gelukt\n", $local_file);
         };
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
