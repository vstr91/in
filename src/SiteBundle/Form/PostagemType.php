<?php

namespace SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostagemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', null, array(
                'label' => 'Título'
            ))
            ->add('resumo', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, array(
                'label' => 'Resumo',
                'attr' => array(
                    'rows' => 5,
                    'class' => 'editor'
                )
            ))
            ->add('descricao', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, array(
                'label' => 'Texto',
                'attr' => array(
                    'rows' => 10,
                    'class' => 'editor'
                )
            ))
            ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'label' => 'Imagem',
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
            'data_class' => 'SiteBundle\Entity\Postagem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sitebundle_postagem';
    }
}
