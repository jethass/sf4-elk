<?php
namespace App\Controller;

use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends AbstractController
{

    public function test()
    {
       /* $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Product::class);
        $prices = $repo->findAllGreaterThanPrice(50);
        dump($prices);die;

        /*$product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(996);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());*/
    }

    /**
     * @Route("/")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Voiture::class);
        $voitures = $repo->findAll();
        return $this->render('Home/index.html.twig', ['voitures' => $voitures]);
    }

    /**
     * @Route("/show/{id}")
     */
    public function show($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Voiture::class);
        $voiture = $repo->findOneBy(['id' => $id]);
        return $this->render('Home/show.html.twig', ['voiture' => $voiture]);
    }
}

