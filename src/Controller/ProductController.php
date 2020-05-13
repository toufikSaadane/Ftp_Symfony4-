<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Services\FtpConnection\FtpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @var FtpService
     */
    private $ftpService;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(FtpService $ftpService,
                                ProductRepository $productRepository
    )
    {
        $this->ftpService=$ftpService;
        $this->productRepository=$productRepository;
    }

    /**
     * @Route("/", name="ftp_test")
     */
    public function index()
    {

        return $this->render('ftp_test/index.html.twig', [
            'pagination' => $this->productRepository->findAllProducts(),
            'controller_name' => 'FtpTestController'
        ]);
    }
}
