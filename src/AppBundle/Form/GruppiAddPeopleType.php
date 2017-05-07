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

class GruppiAddPeopleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descrizione')
//            ->add('elencoPersone', CollectionType::class, array(
//                'entry_type' => PersoneNestedType::class,
//                //'entry_type' => PersoneType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//                //'by_reference' => false))
            ->add('elencoPersone', Select2EntityType::class, [
//                'mapped' =>false,
                'multiple' => true,
                'remote_route' => 'select2_persone',
                'class' => 'AppBundle\Entity\Persone',
                'primary_key' => 'id',
//                'text_property' => 'getDescrizione',
                'text_property' => 'codiceFiscale',
                'minimum_input_length' => 2,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'it',
                'placeholder' => 'codice fiscale',
                // 'em' => $entityManager, // inject a custom entity manager
            ])
            ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Gruppi'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_gruppi';
    }


}
