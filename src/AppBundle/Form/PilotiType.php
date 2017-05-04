<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class PilotiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nome')
            ->add('cognome')
            ->add('dataNascita', DateType::class, array(
                'input' => 'datetime',
                'widget' => 'single_text',
                'label' => 'Data Nascita',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => array(
                    'class' => 'date',
                    //'value' => (new \DateTime('now'))->modify('-32 year')->format('d/m/Y')
                ),
                'constraints' => new NotNull(array('message' => 'campo obbligatorio'))
            ))
            ->add('codiceFiscale')
            ->add('email', TextType::class, array(
                'label' => 'email',
                'constraints' => new Regex(
                    array(

                        'message' => "l'indirizzo '{{ value }}' non è un indirizzo email valido.",
                        'pattern' => '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/'
                    )
                )))
            ->add('idGruppo',
                EntityType::class,
                array(
                    'class' => 'AppBundle:Gruppi',
                    'choice_label' => 'descrizione',
                    'placeholder' => 'selezionare un gruppo'
    //                ,'constraints' => new NotNull(array('message' => 'campo obbligatorio'))
                )
            )

//            ->add('idGruppo', Select2EntityType::class, [
//                'multiple' => false,
//                'remote_route' => 'select2_gruppi',
//                'class' => 'AppBundle\Entity\Gruppi',
//                'primary_key' => 'id',
//                'text_property' => 'descrizione',
//                'minimum_input_length' => 2,
//                'page_limit' => 10,
//                'allow_clear' => true,
//                'delay' => 250,
//                'cache' => true,
//                'cache_timeout' => 60000, // if 'cache' is true
//                'language' => 'it',
//                'placeholder' => 'Seleziona un gruppo',
//            ])
            ->add('idSquadra', EntityType::class, array(
                'class' => 'AppBundle:Squadre',
                'choice_label' => 'nome',
                'placeholder' => 'selezionare una squadra',
                'constraints' => new NotNull(array('message' => 'campo obbligatorio'))))
//            ->add('idSquadra', Select2EntityType::class, [
//                'multiple' => false,
//                'remote_route' => 'select2_squadre',
//                'class' => 'AppBundle\Entity\Squadre',
//                'primary_key' => 'id',
//                'text_property' => 'nome',
//                'minimum_input_length' => 3,
//                'page_limit' => 10,
//                'allow_clear' => true,
//                'delay' => 250,
//                'cache' => true,
//                'cache_timeout' => 60000, // if 'cache' is true
//                'language' => 'it',
//                'placeholder' => 'Seleziona una squadra',
//            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Persone'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_persone';
    }


}
