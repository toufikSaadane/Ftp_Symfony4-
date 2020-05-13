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


    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('ftp:downloadFile')
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io=new SymfonyStyle($input, $output);
        $arg1=$input->getArgument('arg1');

        if (!empty($arg1)) {
            $dis=$this->container->getParameter('files') . $arg1;
            if ($this->ftpService->downloadFtp($dis, $arg1)) {
                printf("===================download %s, is gelukt\n", $arg1);
            }else {
                throw new \Exception(" ===================Upload niet gelukt\n");
            }
        }else{
            throw new \Exception(" =================== argument please\n");
        }
        return 0;
    }
}
