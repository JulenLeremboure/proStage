<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('mailContact')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('formations',EntityType::class,
                ['class'=>Formation::class,
                'choice_label'=>'nom',
                'multiple'=>true,
                'expanded'=>true])
            /*->add('entreprise',EntityType::class,
                ['class'=>Entreprise::class,
                    'choice_label'=>'nom',
                    'multiple'=>false,
                    'expanded'=>false])*/
            ->add('entreprise',EntrepriseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
