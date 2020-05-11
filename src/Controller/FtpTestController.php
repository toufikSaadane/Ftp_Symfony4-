<?php

namespace App\Controller;

use App\Services\FtpConnection\FtpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FtpTestController extends AbstractController
{
    /**
     * @var FtpService
     */
    private $ftpService;

    public function __construct(FtpService $ftpService)
    {
        $this->ftpService=$ftpService;
    }

    /**
     * @Route("/", name="ftp_test")
     */
    public function index()
    {
        $local_file = "AppFTP.csv";
        $dis = $this->getParameter('files')."$local_file";
        dd($this->ftpService->downloadFtp($dis));
        return $this->render('ftp_test/index.html.twig', [
            'controller_name' => 'FtpTestController',
        ]);
    }
}
