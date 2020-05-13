<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Services\FtpConnection\FtpService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * ProductController constructor.
     * @param FtpService $ftpService
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(FtpService $ftpService,
                                ProductRepository $productRepository,
                                EntityManagerInterface $manager
    )
    {
        $this->ftpService=$ftpService;
        $this->productRepository=$productRepository;
        $this->manager=$manager;
    }

    /**
     * @Route("/", name="ftp_test")
     */
    public function index()
    {

        return $this->render('ftp_test/index.html.twig', [
            'pagination'=>$this->productRepository->findAllProducts(),
            'controller_name'=>'FtpTestController'
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {
        $product=new Product();
        $form=$this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($product);
            $this->manager->flush();
            return $this->redirectToRoute('ftp_test');
        }
        return $this->render('ftp_test/add.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
