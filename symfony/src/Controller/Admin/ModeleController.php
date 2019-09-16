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

class ModeleController extends AbstractController
{

    /**
     * @Route("/admin/voitures/modele/create" , name="create_modele")
     */
    public function CreateModele(Request $request)
    {
        $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();
            $this->addFlash('success','Modele  enregistrée.');
        }
        return $this->render('Admin/createModele.html.twig', ['form'=> $form->createView(),'id' => null]);
    }

    /**
     * @Route("/admin/voitures/modele/edit/{id}", name="edit_modele")
     */
    public function EditModele(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $modele = $entityManager->getRepository(Modele::class)->findOneBy(array('id' => $id));

        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Modele  modifié.');
        }
        return $this->render('Admin/createModele.html.twig', ['form'=> $form->createView(), 'id' => $modele->getId()]);
    }

    /**
     * @Route("/getmodelsmarque/{id_marque}", options={"expose"=true}, name="modeles_for_marque")
     */
    public function getModelsMarqueAction(Request $request,$id_marque)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $modeles_list = $em->getRepository(Modele::class)->findBy(array('marque' => $id_marque));
            if ($modeles_list){
                $modeles = array();

                foreach ($modeles_list as $modele){
                    $modeles[$modele->getId()]=$modele->getLabel();
                }
            }  else{
                $modeles = null;
            }

            $response = new JsonResponse();

            return $response->setData(array('modeles'=>$modeles));
        }else{
            throw new \Exception('erreur');
        }
    }

    /**
     * @Route("/admin/voitures/modele/liste", name="liste_modele")
     */
    public function ListeModele(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Modele::class);
        $modeles = $repo->findAll();
        return $this->render('Admin/listeModele.html.twig', ['modeles' => $modeles]);
    }


    /**
     * @Route("/admin/voitures/modele/delete/{id}", name="delete_modele")
     */
    public function deleteMarque(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $modele = $entityManager->getRepository(Modele::class)->findOneBy(array('id' => $id));
        $em = $this->getDoctrine()->getManager();
        $em->remove($modele);
        $em->flush();
        $this->addFlash('success','modèle  supprimé.');
        return $this->redirectToRoute('liste_modele');
    }


}
