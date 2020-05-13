<?php


namespace App\Services\ManipulatingData;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class DataManipulator
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ContainerInterface $container,
                                EntityManagerInterface $entityManager)
    {
        $this->container=$container;
        $this->entityManager=$entityManager;
    }

    public function getFile(string $fileName)
    {
        $file=$this->container->getParameter('files') . $fileName;
        return file_get_contents($file);
    }

    public function decodeFileContent(string $fileName)
    {
        $encoder=new XmlEncoder();
        $data=$this->getFile($fileName);
        return $encoder->decode($data, 'xml');
    }

    public function toSql($file)
    {
        foreach ($this->decodeFileContent($file) as $globalArray) {
            foreach ($globalArray as $simpleProduct) {
                $product=new Product();
                $product->setTitle($simpleProduct["title"]);
                $product->setDescription($simpleProduct["description"]);
                $product->setHeight($simpleProduct["height"]);
                $product->setRootstock($simpleProduct["rootstock"]);
                $product->setPrice($simpleProduct["price"]);
                $this->entityManager->persist($product);
            }
        }
        $this->entityManager->flush();
        return "naar the DB";
    }
}