<?php

namespace SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'label' => 'Banner em Computadores',
                'required' => false
            ))
            ->add('fileMob', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'label' => 'Banner em Dispositivos Móveis',
                'required' => false
            ))
            ->add('link', null, array(
                'label' => 'Link (Com o http:// ou https://). Ex.: http://www.google.com'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Banner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sitebundle_banner';
    }
}
