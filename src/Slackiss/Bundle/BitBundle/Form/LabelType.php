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
            ->add('name', 'text', [
                'label' => '标签名字',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('sequence', null, [
                'label' => '序号',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('attach', 'file', [
                'label' => '标签图片',
                'required' => !$this->isEdit,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('html', 'ckeditor', array(
                'label' => '内容',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'filebrowser_image_browse_url' => array(
                    'route' => 'elfinder',
                    'route_parameters' => array(),
                ),
            ))
            ->add('labelType', null, [
                'label' => '类型',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', 'textarea', [
                'label' => '标签介绍',
                'required' => true,
                'attr' => [
                    'rows' => 8,
                    'class' => 'form-control'
                ]
            ])

            ->add('remark', 'textarea', [
                'label' => '评论',
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
