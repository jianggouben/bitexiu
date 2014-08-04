<?php

namespace Slackiss\Bundle\BitBundle\Controller\Manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Slackiss\Bundle\BitBundle\Entity\LabelType;
use Slackiss\Bundle\BitBundle\Form\LabelTypeType;

/**
 * LabelType controller.
 *
 * @Route("/manager/labelType")
 */
class LabelTypeController extends Controller
{

    /**
     * Lists all LabelType entities.
     *
     * @Route("/", name="manager_labelType")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page',1);
        $repo = $em->getRepository('SlackissBitBundle:LabelType');
        $query = $repo->createQueryBuilder('a')
            ->orderBy('a.sequence','desc')
            ->getQuery();
        $entities = $this->get('knp_paginator')->paginate($query,$page,50);

        return array(
            'nav_active'=>'nav_active_labelType',
            'entities' => $entities,
        );
    }
    /**
     * Creates a new LabelType entity.
     *
     * @Route("/", name="manager_labelType_create")
     * @Method("POST")
     * @Template("SlackissBitBundle:Manager\LabelType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new LabelType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('manager_labelType_show', array('id' => $entity->getId())));
        }

        return array(
            'nav_active'=>'nav_active_labelType',
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a LabelType entity.
     *
     * @param LabelType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(LabelType $entity)
    {
        $form = $this->createForm(new LabelTypeType(), $entity, array(
            'action' => $this->generateUrl('manager_labelType_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }

    /**
     * Displays a form to create a new LabelType entity.
     *
     * @Route("/new", name="manager_labelType_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LabelType();
        $form   = $this->createCreateForm($entity);

        return array(
            'nav_active'=>'nav_active_labelType',
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a LabelType entity.
     *
     * @Route("/{id}", name="manager_labelType_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:LabelType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个标签类型');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'nav_active'=>'nav_active_labelType',
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LabelType entity.
     *
     * @Route("/{id}/edit", name="manager_labelType_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:LabelType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个标签类型');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'nav_active'=>'nav_active_labelType',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a LabelType entity.
    *
    * @param LabelType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(LabelType $entity)
    {
        $form = $this->createForm(new LabelTypeType(), $entity, array(
            'action' => $this->generateUrl('manager_labelType_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }
    /**
     * Edits an existing LabelType entity.
     *
     * @Route("/{id}", name="manager_labelType_update")
     * @Method("PUT")
     * @Template("SlackissBitBundle:Manager\LabelType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:LabelType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个标签类型');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setModified(new \DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('manager_labelType_edit', array('id' => $id)));
        }

        return array(
            'nav_active'=>'nav_active_labelType',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a LabelType entity.
     *
     * @Route("/{id}", name="manager_labelType_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SlackissBitBundle:LabelType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('没找到这个标签类型');
            }
            $entity->setModified(new \DateTime());
            $entity->setEnabled(false);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('manager_labelType'));
    }

    /**
     * Creates a form to delete a LabelType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_labelType_delete', array('id' => $id)))
            ->setMethod('DELETE')
                    ->add('submit', 'submit', array('label' => '删除','attr'=>[
                        'class'=>'btn btn-danger'
                    ]))
            ->getForm()
        ;
    }
}
