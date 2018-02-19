<?php

namespace SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'label' => 'Foto',
                'required' => false
            ))
            ->add('legenda', null, array(
                'label' => 'Legenda',
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Foto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sitebundle_foto';
    }
}
