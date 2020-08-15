<?php

namespace TIC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('trainerLastname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.lastname',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('trainerFirstname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.firstname',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('trainerGSM', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.GSM',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));


        $builder->add('trainerBirthdate', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'label' => 'trainer.birthdate',
            'years'=> range(date('Y')-80, date('Y')+5),
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
        ));

        $builder->add('trainerIdentityCardNumber', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.identity.card.number',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('trainerIdentityCardValidity', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.identity.card.validity',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerNationality', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.nationality',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('trainerNumberPlate', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.number.plate',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => false
        ));

        $builder->add('trainerCarColor', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.car.color',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => false
        ));

        $builder->add('trainerCarModel', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.car.model',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => false
        ));

        $builder->add('trainerBstormMail', 'email', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.bstorm.mail',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => true
        ));

        $builder->add('trainerPersonalMail', 'email', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.personal.mail',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => false
        ));

        $builder->add('trainerClientMail', 'email', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.client.mail',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => false
        ));

        //TODO Retirer form control => attention affichage
        //'custom-date-picker text-center', 'data-date-format' => 'mm-dd-yyyy'

        $builder->add('trainerFirstDay', 'date', array(
            'attr' => array('class' => 'form-control date-picker text-center',
                'data-provide'=>'datepicker',
                'data-date-format' => 'dd-mm-yyyy'),
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'label' => 'trainer.first.day',
            'years'=> range(date('Y')-80, date('Y')+5),
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true,
        ));

        $builder->add('languages', 'entity', array(
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'trainer.language',
            'class' => 'TIC\PlatformBundle\Entity\Languages',
            'choice_label' => 'language',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false,
            'multiple' => true
        ));

        $builder->add('trainerSelfEmployed', 'checkbox', array(
            'label' => 'trainer.self.employed',
            'label_attr' => array('class' => 'control-label col-md-4'),
            'required' => false
        ));

        $builder->add('employer', 'entity', array(
            'class' => 'TIC\PlatformBundle\Entity\Employer',
            'choice_label' => 'employerName',
            'attr' => array('class' => 'form-control search-select'),
            'label' => 'employer',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerTVANumber', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.TVA.number',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerDayCost', 'number', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.daily.wage',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('address', new AddressesType());

        $builder->add('Country', 'entity', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.country',
            'class' => 'TIC\PlatformBundle\Entity\Countries',
            'choice_label' => 'countryName',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerKilometreRates', 'number', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'trainer.kilometre.rates',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerCalendarID', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'calendar.id',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerActive', 'checkbox', array(
            'label' => 'active',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => false
        ));

        $builder->add('trainerColor', 'text', array(
            'attr' => array('class' => 'form-control color-picker'),
            'label' => 'color',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('trainerTextColor', 'text', array(
            'attr' => array('class' => 'form-control color-picker'),
            'label' => 'text.color',
            'label_attr' => array('class' => 'control-label col-md-3'),
            'required' => true
        ));

        $builder->add('save','submit', array(
            'attr' => array('class'=>'btn btn-primary btn-block')
        ));

        $builder->add('documentCv', new DocumentFormType(false, 'CV'), array(
            'data_class' => 'TIC\PlatformBundle\Entity\Document'
        ));

        $builder->add('documentsIdentityCard', new DocumentFormType(false, 'id.scan', true), array(
            'data_class' => null,
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TIC\PlatformBundle\Entity\Trainers'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tic_platformbundle_trainers';
    }
}
