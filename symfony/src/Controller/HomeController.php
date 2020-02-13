<?php
namespace App\Controller;

use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends AbstractController
{

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
     * @Route("/nos-vehicules", name="nos_veihcules)
     */
    public function nosVehicules()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Voiture::class);
        $voitures = $repo->findAll();
        return $this->render('Home/nosveihicules.html.twig', ['voitures' => $voitures]);
    }

    /**
     * @Route("/vehicule/{id}", name="detail_vehicule)
     */
    public function detail($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Voiture::class);
        $voiture = $repo->findOneBy(['id' => $id]);
        return $this->render('Home/show.html.twig', ['voiture' => $voiture]);
    }
}

