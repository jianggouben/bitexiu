<?php

namespace Slackiss\Bundle\BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollocationType extends AbstractType
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
                    'class' => 'form-control'
                ]
            ))
            ->add('attach', 'file', [
                'label' => '图片',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', 'text', array(
                'label' => '价格',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ))

            ->add('hot')
            //   ->add('created')
            //  ->add('modified')
            //    ->add('status')
            //  ->add('enabled')
            // ->add('remark')
            //->add('state')
            ->add('labels',null, [
                'label' => '标签',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', 'textarea', [
                'label' => '说明',
                'required' => false,
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
            'data_class' => 'Slackiss\Bundle\BitBundle\Entity\Collocation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'slackiss_bundle_bitbundle_collocation';
    }
}
