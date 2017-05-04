<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class PersoneNestedType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('id'
//                , EntityType::class, array(
//                'class' => 'AppBundle:Persone'
//                ,'choice_label' => function ($id) {
//                        return $id->getCodiceFiscale();
//                    }
                //,'choice_label' => 'codiceFiscale'
                //,'placeholder' => 'selezionare un id persona'
//                )
////                , Select2EntityType::class, [
////                    'multiple' => false,
////                    'remote_route' => 'select2_persone',
////                    'class' => 'AppBundle\Entity\Persone',
////                    'primary_key' => 'id',
////                    'text_property' => 'codiceFiscale',
////                    'minimum_input_length' => 2,
////                    'page_limit' => 10,
////                    'allow_clear' => true,
////                    'delay' => 250,
////                    'cache' => true,
////                    'cache_timeout' => 60000,
////                    'language' => 'it',
////                    'placeholder' => 'Seleziona un CF',
////                ]
//            )
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
            ->add('codiceFiscale'
//                , EntityType::class, array(
//                    'class' => 'AppBundle:Persone',
//                    'choice_label' => 'codiceFiscale'
//                    //,'placeholder' => 'selezionare un id persona'
//                )
////                , Select2EntityType::class, [
////                'multiple' => false,
////                'remote_route' => 'select2_persone',
////                'class' => 'AppBundle\Entity\Persone',
////                'primary_key' => 'id',
////                'text_property' => 'codiceFiscale',
////                'minimum_input_length' => 2,
////                'page_limit' => 10,
////                'allow_clear' => true,
////                'delay' => 250,
////                'cache' => true,
////                'cache_timeout' => 60000,
////                'language' => 'it',
////                'placeholder' => 'Seleziona un CF',
////                ]
            )
            ->add('email', TextType::class, array(
                'label' => 'email',
                'constraints' => array(
                    new Regex(
                        array(
                            'message' => "l'indirizzo '{{ value }}' non è un indirizzo email valido.",
                            'pattern' => '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/'
                        ))
                    ,
                    new NotNull(array('message' => 'campo obbligatorio'))
                )
//                'constraints' => new Regex(
//                    array(
//                        'message' => "l'indirizzo '{{ value }}' non è un indirizzo email valido.",
//                        'pattern' => '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/'
//                    ))
            ))
            ->add('idGruppo'
                , EntityType::class, array(
                    'class' => 'AppBundle:Gruppi',
                    'choice_label' => 'descrizione'
                    //,'placeholder' => 'selezionare un id persona'
                )
//                , Select2EntityType::class, [
//                'multiple' => false,
//                'remote_route' => 'select2_gruppi',
//                'class' => 'AppBundle\Entity\Gruppi',
//                'primary_key' => 'id',
//                'text_property' => 'descrizione',
//                'minimum_input_length' => 3,
//                'page_limit' => 10,
//                'allow_clear' => true,
//                'delay' => 250,
//                'cache' => true,
//                'cache_timeout' => 60000, // if 'cache' is true
//                'language' => 'it',
//                'placeholder' => 'Seleziona un gruppo',
//                // 'em' => $entityManager, // inject a custom entity manager
//                ]
            )
            ->add('idSquadra'
                , EntityType::class, array(
                    'class' => 'AppBundle:Squadre'
                    ,'choice_label' => 'nome'
                    ,'placeholder' => 'selezionare id squadra'
                )
//                , Select2EntityType::class, [
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
//                ]
        )
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
