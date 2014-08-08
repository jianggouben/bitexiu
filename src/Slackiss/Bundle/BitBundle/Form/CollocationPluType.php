<?php

namespace Slackiss\Bundle\BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Slackiss\Bundle\BitBundle\Entity\CollocationRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
class CollocationPluType extends AbstractType
{


    protected $isEdit, $current;

    public function __construct($isEdit = false, $current)
    {
        $this->isEdit = $isEdit;
        $this->current = $current;
    }

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
                ],
                'constraints'   => array(
                    new NotBlank(),
                    new Type(array('type' => 'numeric')),
                )
            ])
            ->add('attach', 'file', [
                'label' => '图片',
                'required' => !$this->isEdit,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('collocation', 'entity', array(
                    'label' => '所属搭配',
                    'required' => false,
                    'class' => 'SlackissBitBundle:Collocation',
                    'property' => 'description',
                    'multiple' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'query_builder' => function (CollocationRepository $r) {
                            return $r->getSelectList($this->current);
                        }
                )
            );

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
