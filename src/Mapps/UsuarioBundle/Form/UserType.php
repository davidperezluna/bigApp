<?php

namespace Mapps\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username')
        ->add('nombres')
        ->add('apellidos')
        ->add('identificacion')
        ->add('celular')
        ->add('direccion')
        ->add('direccion')
        ->add('email', EmailType::class)
        ->add('genero', ChoiceType::class, array(
            'choices'  => array(
                'Masculino' => "masculino",
                'Femenino' => "femenino",
            ),
        ))
        ->add('rolePersona', ChoiceType::class, array(
            'choices'  => array(
                'Administrador' => "ROLE_ADMIN",
                'Usuaio' => "ROLE_USER",
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
