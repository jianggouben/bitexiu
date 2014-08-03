<?php

namespace Slackiss\Bundle\BitBundle\Controller\Manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Slackiss\Bundle\BitBundle\Entity\Label;
use Slackiss\Bundle\BitBundle\Form\LabelType;

/**
 * Label controller.
 *
 * @Route("/manager/label")
 */
class LabelController extends Controller
{

    /**
     * Lists all Label entities.
     *
     * @Route("/", name="manager_label")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page',1);
        $repo = $em->getRepository('SlackissBitBundle:Label');
        $query = $repo->createQueryBuilder('a')
            ->orderBy('a.sequence','desc')
            ->getQuery();
        $entities = $this->get('knp_paginator')->paginate($query,$page,50);

        return array(
            'nav_active'=>'nav_active_label',
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Label entity.
     *
     * @Route("/", name="manager_label_create")
     * @Method("POST")
     * @Template("SlackissBitBundle:Manager/Label:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Label();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('manager_label_show', array('id' => $entity->getId())));
        }

        return array(
            'nav_active'=>'nav_active_label',
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Label entity.
     *
     * @param Label $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Label $entity)
    {
        $form = $this->createForm(new LabelType(), $entity, array(
            'action' => $this->generateUrl('manager_label_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }

    /**
     * Displays a form to create a new Label entity.
     *
     * @Route("/new", name="manager_label_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Label();
        $form   = $this->createCreateForm($entity);

        return array(
            'nav_active'=>'nav_active_label',
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Label entity.
     *
     * @Route("/{id}", name="manager_label_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SlackissBitBundle:Label')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个标签');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'nav_active'=>'nav_active_label',
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Label entity.
     *
     * @Route("/{id}/edit", name="manager_label_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Label')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个标签');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'nav_active'=>'nav_active_label',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Label entity.
    *
    * @param Label $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Label $entity)
    {
        $form = $this->createForm(new LabelType(true), $entity, array(
            'action' => $this->generateUrl('manager_label_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }
    /**
     * Edits an existing Label entity.
     *
     * @Route("/{id}", name="manager_label_update")
     * @Method("PUT")
     * @Template("SlackissBitBundle:Manager/Label:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Label')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个标签');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setModified( new \DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('manager_label_edit', array('id' => $id)));
        }

        return array(
            'nav_active'=>'nav_active_label',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Label entity.
     *
     * @Route("/{id}", name="manager_label_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SlackissBitBundle:Label')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('没找到这个标签');
            }
            $entity->setModified( new \DateTime());
            $entity->setEnabled( false);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('manager_label'));
    }

    /**
     * Creates a form to delete a Label entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_label_delete', array('id' => $id)))
            ->setMethod('DELETE')
                    ->add('submit', 'submit', array('label' => '禁用','attr'=>[
                        'class'=>'btn btn-danger'
                    ]))
            ->getForm()
        ;
    }
}
