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

class PersoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('cognome')
            // sostituzione di lez n 6 su validazione campi
            //->add('dataNascita')
            // http://symfony.com/doc/current/reference/forms/types/date.html
            ->add('dataNascita', DateType::class, array(
                'input' => 'datetime',
                'widget' => 'single_text',
                'label' => 'Data Nascita',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => array(
                    'class' => 'date',
                    //altrimenti il vlaore che appare in edit non è quello memorizzato nel db
                    //'value' => (new \DateTime('now'))->modify('+2 year')->format('d/m/Y')
                ),
                'constraints' => new NotNull(array('message' => 'campo obbligatorio'))
            ))
            ->add('codiceFiscale', TextType::class, array(
                    'constraints' => new NotNull(array('message' => 'campo obbligatorio'))
                )
            )
            // aggiunta di lez n 6 su validazione campi
            ->add('email',
                TextType::class, array(
                'label' =>'email',
//                'constraints' => array(
//                    new Regex(
//                        array(
//                            'message' => "l'indirizzo '{{ value }}' non è un indirizzo email valido.",
//                            'pattern' => '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/'
//                        )),
//                    new NotNull(array('message' => 'campo obbligatorio'))
//                    )
                    'constraints' => new Regex(
                        array(
                            'message' => "l'indirizzo '{{ value }}' non è un indirizzo email valido.",
                            'pattern' => '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/'
                        ))
                ))
//            Inserito e sostituito nell'arco della lez n. 7 del 21/3/2107
//            ->add('idGruppo', EntityType::class, array(
//                'class' => 'AppBundle:Gruppi',
//                'choice_label' => 'Descrizione',
//                'placeholder' => 'Selezionare un gruppo',
//                'constraints' => new NotNull(array('message' => 'Campo obbligatorio'))))
            ->add('idGruppo', Select2EntityType::class, [
                'multiple' => false,  // inserimento valori multipli (array). Nota: nel caso di valore 'true' avremmo errore (che non ricordo) in fase di editing
                'remote_route' => 'select2_gruppi',
                'class' => 'AppBundle\Entity\Gruppi',
                'primary_key' => 'id',
                'text_property' => 'descrizione',   //This is the entity property used to retrieve the text for existing data. If text_property is omitted then the entity is cast to a string. This requires it to have a __toString() method.
                'minimum_input_length' => 2,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'it',
                'placeholder' => 'Selezionare il gruppo',
                // 'em' => $entityManager, // inject a custom entity manager
            ])
            ->add('idSquadra', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'select2_squadre',
                'class' => 'AppBundle\Entity\Squadre',
                'primary_key' => 'id',
                'text_property' => 'nome',
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'it',
                'placeholder' => 'Seleziona una squadra',
            ])
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
