<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Media;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $categories= $this->entityManager->getRepository(Category::class)->findAll();
        $fruits= $this->entityManager->getRepository(Product::class)->findBy(['category'=>1]); 
        $laitiers= $this->entityManager->getRepository(Product::class)->findBy(['category'=>3]);
        $viandes= $this->entityManager->getRepository(Product::class)->findBy(['category'=>4]); 
        $volailles= $this->entityManager->getRepository(Product::class)->findBy(['category'=>5]);  
        $poissons= $this->entityManager->getRepository(Product::class)->findBy(['category'=>6]);
        $pains= $this->entityManager->getRepository(Product::class)->findBy(['category'=>7]);
        $boissons= $this->entityManager->getRepository(Product::class)->findBy(['category'=>8]);
        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'fruits' => $fruits,
            'laitiers' => $laitiers,
            'viandes' => $viandes,
            'volailles' => $volailles,
            'poissons' => $poissons,
            'pains' => $pains,
            'boissons' => $boissons,
        ]);
    }
}
