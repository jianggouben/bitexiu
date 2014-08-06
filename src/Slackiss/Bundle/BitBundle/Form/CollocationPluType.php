<?php

namespace Slackiss\Bundle\BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollocationPluType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => '名称',
                'required' => true,
                'attr' => [
                    'class'=> 'form-control'
                ]
            ))
            ->add('url', 'text', array(
                'label' => '网址',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ))
            ->add('price', 'text', array(
                'label' => '价格',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ))
            ->add('sequence', null, [
                'label' => '权重',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('attach', 'file', [
                'label' => '图片',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('collocation')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Slackiss\Bundle\BitBundle\Entity\CollocationPlu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'slackiss_bundle_bitbundle_collocationplu';
    }
}
