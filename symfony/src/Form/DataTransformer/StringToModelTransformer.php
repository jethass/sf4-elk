<?php
namespace App\Form\DataTransformer;

use App\Entity\Modele;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToModelTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (Model) to a string (name model).
     *
     */
    public function transform($model)
    {
        if (null === $model) {
            return '';
        }

        return $model->getLabel();
    }

    /**
     * Transforms a model_id to an object (Model).
     *
     */
    public function reverseTransform($model_id)
    {
        if (!$model_id) {
            return;
        }

        $model = $this->manager
            ->getRepository(Modele::class)
            ->find($model_id)
        ;

        if (null === $model) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $model_id
            ));
        }

        return $model;
    }
}