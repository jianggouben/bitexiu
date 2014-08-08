<?php

namespace Slackiss\Bundle\BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

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
                'required' => false,
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
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => array(
                    new NotBlank(),
                    new Type(array('type' => 'numeric')),
                )
            ])
            ->add('html', 'text', array(
                'label' => 'HTML',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ))
            ->add('description', 'textarea', [
                'label' => '说明',
                'required' => false,
                'attr' => [
                    'rows' => 8,
                    'class' => 'form-control'
                ]
            ])
            ->add('attach', 'file', [
                'label' => '图片',
                'required' => false,
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
