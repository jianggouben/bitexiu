<?php

namespace Slackiss\Bundle\BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LabelTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => '标签类型名字',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            //   ->add('status')
            //   ->add('enabled')
            //  ->add('created')
            //  ->add('modified')
            ->add('sequence')
            ->add('description', 'textarea', [
                'label' => '标签类型介绍',
                'required' => true,
                'attr' => [
                    'rows' => 8,
                    'class' => 'form-control'
                ]
            ])

            ->add('remark', 'textarea', [
                'label' => '标签类型评论',
                'required' => true,
                'attr' => [
                    'rows' => 8,
                    'class' => 'form-control'
                ]
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Slackiss\Bundle\BitBundle\Entity\LabelType'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'slackiss_bundle_bitbundle_labeltype';
    }
}
