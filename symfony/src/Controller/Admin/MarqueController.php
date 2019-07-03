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

class MarqueController extends AbstractController
{

    /**
     * @Route("/admin/voitures/marque/create", name="create_marque")
     */
    public function CreateMarque(Request $request)
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();

            $this->addFlash('success','Marque  enregistrée.');
        }
        return $this->render('Admin/createMarque.html.twig', ['form'=> $form->createView(), 'id' => null]);
    }

    /**
     * @Route("/admin/voitures/marque/liste", name="liste_marque")
     */
    public function ListeMarque(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Marque::class);
        $marques = $repo->findAll();
        return $this->render('Admin/listeMarque.html.twig', ['marques' => $marques]);
    }

    /**
     * @Route("/admin/voitures/marque/edit/{id}", name="edit_marque")
     */
    public function EditMarque(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $marque = $entityManager->getRepository(Marque::class)->findOneBy(array('id' => $id));

        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Marque  modifié.');
        }
        return $this->render('Admin/createMarque.html.twig', ['form'=> $form->createView(), 'id' => $marque->getId()]);
    }

    /**
     * @Route("/admin/voitures/marque/delete/{id}", name="delete_marque")
     */
    public function deleteMarque(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $marque = $entityManager->getRepository(Marque::class)->findOneBy(array('id' => $id));
        $em = $this->getDoctrine()->getManager();
        $em->remove($marque);
        $em->flush();
        $this->addFlash('success','Marque  supprimé.');
        return $this->redirectToRoute('liste_marque');
    }


}
