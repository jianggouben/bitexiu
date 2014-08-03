<?php

namespace Slackiss\Bundle\BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LabelType extends AbstractType
{
    protected $isEdit;

    public function __construct($isEdit = false)
    {
        $this->isEdit = $isEdit;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('labelType', null, [
                'label' => '类型',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('name', 'text', [
                'label' => '名称',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('sequence', null, [
                'label' => '权重',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('html', 'text', array(
                'label' => 'HTML',
                'attr' => array(
                    'class'=> 'form-control',
                    'rows'=>6
                ),
            ))
            ->add('description', 'textarea', [
                'label' => '说明',
                'required' => true,
                'attr' => [
                    'rows' => 8,
                    'class' => 'form-control'
                ]
            ])
            ->add('attach', 'file', [
                'label' => '图片',
                'required' => !$this->isEdit,
                'attr' => [
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
            'data_class' => 'Slackiss\Bundle\BitBundle\Entity\Label'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'slackiss_bundle_bitbundle_label';
    }
}
