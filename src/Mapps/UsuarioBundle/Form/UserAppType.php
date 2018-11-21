<?php

namespace Mapps\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserAppType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombres')
        ->add('apellidos')
        ->add('celular')
        ->add('email', EmailType::class)
        ->add('rolePersona', ChoiceType::class, array(
            'choices'  => array(
                'Usuario' => "ROLE_USER",
                'Empresa' => "ROLE_EMPRESA",
            ),
        ))
        ->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Las Contraseñas no coinciden.',
            'required' => true,
            'first_options'  => array('label' => 'Contraseña'),
            'second_options' => array('label' => 'Repita Contraseña'),
        )); 
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
        ->setDefaults(array(
            'data_class' => 'Mapps\UsuarioBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mapps_usuariobundle_user';
    }

}
