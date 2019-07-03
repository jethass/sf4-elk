<?php
namespace App\Controller\Admin;

use App\Entity\Voiture;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Form\Type\VoitureType;
use App\Form\Type\MarqueType;
use App\Form\Type\ModeleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VoitureController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(Request $request)
    {
            return $this->redirectToRoute('liste_voiture');
    }

    /**
     * @Route("/admin/voitures/create", name="create_voiture")
     */
    public function createVoiture(Request $request)
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            $this->addFlash('success','Voiture  enregistrée.');
            return $this->redirectToRoute('create_voiture');
        }

        return $this->render('Admin/createVoiture.html.twig', ['form' =>  $form->createView(), 'voiture'	=>	null]);
    }

    /**
     * @Route("/admin/voitures/edit/{id}", name="edit_voiture")
     */
    public function editVoiture(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Voiture::class);
        $voiture = $repo->findOneBy(['id' => $id]);

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            $this->addFlash('success','Voiture  mis a jour.');
            return $this->redirectToRoute('edit_voiture');
        }

        return $this->render('Admin/createVoiture.html.twig', ['form' =>  $form->createView(), 'voiture'	=>	$voiture]);
    }

    /**
     * @Route("/admin/voitures/liste", name="liste_voiture")
     */
    public function ListeVoiture(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Voiture::class);
        $voitures = $repo->findAll();
        return $this->render('Admin/listeVoiture.html.twig', ['voitures' => $voitures]);
    }
}
