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

class FtpUploadFileCommand extends Command
{

    /**
     * @var string|null
     */
    private $name;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var FtpService
     */
    private $ftpService;

    public function __construct(string $name=null,
                                FtpService $ftpService,
                                ContainerInterface $container)
    {
        parent::__construct($name);
        $this->ftpService=$ftpService;
        $this->container=$container;
        $this->name=$name;
    }

    protected function configure()
    {
        $this
            ->setName("ftp:uploadFile")
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io=new SymfonyStyle($input, $output);
        $arg1=$input->getArgument('arg1');
        $fileToUpload = $this->container->getParameter('files').$arg1;
        if ($this->ftpService->uploadFtp( $arg1, $fileToUpload)){
            printf("===================Upload %s, is gelukt\n", $arg1);
        }
        return 0;
    }
}
