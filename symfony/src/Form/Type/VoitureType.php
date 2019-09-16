<?php
namespace App\Form\Type;

use App\Entity\Voiture;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Image;
use App\Entity\Tag;
use App\Form\Type\TagsInputType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\EventListener\VoitureAddListener;
use App\Form\DataTransformer\StringToModelTransformer;


class VoitureType extends AbstractType
{

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $myEntity = $builder->getForm()->getData();
        $builder
            ->add('marque', EntityType::class,
                array(
                    'class'         => Marque::class,
                    'choice_label'    => 'label',
                    'multiple' => false,
                    'expanded' => false,
                )
            )
            ->add('modele', EntityType::class,
                array(
                    'class'         => Modele::class,
                    'choice_label' => 'label',
                    'multiple' => false,
                    'expanded' => false
                )
            )
            /*->add('tags',EntityType::class, array(
                'attr'=>array('class'=>"tags"),
                'label'=>'Options',
                'choice_value' => function (Tag $tag = null) {
                                        return $tag ? $tag->getName() : '';
                 },
                'class' => Tag::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple'=>true
            ))*/
            /*->add('tags', EntityType::class, [
                'label'=>'options',
                'choice_value' => function (Tag $tag = null) {
                    return $tag ? $tag->getName() : '';
                },
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple'=>true
            ])*/
            ->add('tags', TagsInputType::class, [
                'label' => 'Options',
                'required' => false,
            ])
            ->add('prix', TextType::class)
            ->add('kilometrage', TextType::class)
            ->add('dateCirculation', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
            ))
            ->add('boiteVitesse', ChoiceType::class, array(
                    'choices'  => array(
                        'Manuelle' => 'Manuelle',
                        'Auto' => 'Auto',
                    )
                )
            )
            ->add('carburant', ChoiceType::class, array(
                    'choices'  => array(
                        'Essence' => 'Essence',
                        'Diesel' => 'Diesel',
                        'GPL' => 'GPL',
                        'Eléctrique' => 'Electrique',
                    )
                )
            )
            ->add('puissanceFiscal', TextType::class)
            ->add('couleur', ChoiceType::class, array(
                    'choices'  => array(
                        'Blanc' => 'Blanc',
                        'Noir' => 'Noir',
                        'Gris' => 'Gris',
                        'Bleu' => 'Bleu',
                        'Rouge' => 'Rouge',
                        'Vert' => 'Vert',
                    )
                )
            )
            ->add('premiereMain', ChoiceType::class, array(
                    'choices'  => array(
                        'Oui' => '1',
                        'Non' => '0',
                    )
                )
            )
            ->add('nombreDePorte', ChoiceType::class, array(
                    'choices'  => array(
                        '3' => '3',
                        '5' => '5',
                    )
                )
            )
            ->add('images', CollectionType::class, array(
                'entry_type'   		=> ImageType::class,
                'prototype'			=> true,
                'allow_add'			=> true,
                'allow_delete'		=> true,
                'by_reference' 		=> false,
                'required'			=> false,
                'label'			    => false,
            )
        );

        $builder->get('marque')->addEventSubscriber(new VoitureAddListener($this->manager));
        $builder->get('modele')->addModelTransformer(new StringToModelTransformer($this->manager));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
            'modele' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_voiture';
    }
}