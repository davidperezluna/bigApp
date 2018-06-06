<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EmpresaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre')
        ->add('correo')
        ->add('telefono', NumberType::class, array(
        ))
        ->add('celular', NumberType::class, array(
        ))
        ->add('nit')
        ->add('fotoLogo', FileType::class, array('data_class' => null))
        ->add('fotoPortada', FileType::class, array('data_class' => null))
        ->add('paginaWeb')
        ->add('descripcion')
        ->add('direccion')
        ->add('lat')
        ->add('lng')
        ->add('colorPrimario')
        ->add('colorSecundario')
        ->add('usuario', EntityType::class, array(
            'class' => 'MappsUsuarioBundle:User',
            'choice_label' => 'nombres',
        ))
        ->add('municipio', EntityType::class, array(
            'class' => 'AppBundle:Municipio',
            'choice_label' => 'nombre',
        ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
        ->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Empresa'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_empresa';
    }


}
