<?php
namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Modele;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VoitureAddListener implements EventSubscriberInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents:: POST_SUBMIT  => 'onPostSubmit',
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm()->getParent();
        $data =  $event->getData();
        $marqueId = ($data != null) ? $data->getId() : 13;
        $modeles = $this->manager->getRepository(Modele::class)->findBy(array('marque' => $marqueId));
        $form ->add('modele', EntityType::class, array(
                'attr'=>array('class'=>'modeles'),
                'class'         => Modele::class,
                'choice_label' => 'label',
                'multiple' => false,
                'expanded' => false,
                'choices'  => $modeles,
            )
        );
    }
    public function onPostSubmit(FormEvent $event)
    {
        $form = $event->getForm()->getParent();
        $marque = $event->getForm()->getData();
        $modeles = $this->manager->getRepository(Modele::class)->findBy(array('marque' => $marque->getId()));

        $form ->add('modele', EntityType::class, array(
                'attr'=>array('class'=>'modeles'),
                'class'         => Modele::class,
                'choice_label' => 'label',
                'multiple' => false,
                'expanded' => false,
                'choices'  => $modeles,
            )
        );
    }
}