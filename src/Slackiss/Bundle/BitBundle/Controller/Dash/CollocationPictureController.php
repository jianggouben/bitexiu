<?php

namespace Slackiss\Bundle\BitBundle\Controller\Dash;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Slackiss\Bundle\BitBundle\Entity\CollocationPicture;
use Slackiss\Bundle\BitBundle\Form\CollocationPictureType;

/**
 * CollocationPicture controller.
 *
 * @Route("/dash/collocationPicture")
 */
class CollocationPictureController extends Controller
{

    /**
     * Lists all CollocationPicture entities.
     *
     * @Route("/", name="dash_collocationPicture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $page = $request->query->get('page',1);
        $repo = $em->getRepository('SlackissBitBundle:CollocationPicture');
        $current = $this->get('security.context')->getToken()->getUser();
        $query = $repo->createQueryBuilder('a')
            ->orderBy('a.sequence','desc')
            ->where('a.status = :status')
            ->andWhere('a.member = :member')
            ->setParameters(array('status'=>true,'member'=>$current->getId()))
            ->getQuery();
        $entities = $this->get('knp_paginator')->paginate($query,$page,50);


        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CollocationPicture entity.
     *
     * @Route("/", name="dash_collocationPicture_create")
     * @Method("POST")
     * @Template("SlackissBitBundle:CollocationPicture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CollocationPicture();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $current = $this->get('security.context')->getToken()->getUser();
            $entity->setMember($current);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dash_collocationPicture_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CollocationPicture entity.
     *
     * @param CollocationPicture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CollocationPicture $entity)
    {
        $form = $this->createForm(new CollocationPictureType(), $entity, array(
            'action' => $this->generateUrl('dash_collocationPicture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }

    /**
     * Displays a form to create a new CollocationPicture entity.
     *
     * @Route("/new", name="dash_collocationPicture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CollocationPicture();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CollocationPicture entity.
     *
     * @Route("/{id}", name="dash_collocationPicture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPicture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配图片.');
        }

        $current = $this->get('security.context')->getToken()->getUser();
        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocationPicture'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CollocationPicture entity.
     *
     * @Route("/{id}/edit", name="dash_collocationPicture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPicture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配图片.');
        }
        $current = $this->get('security.context')->getToken()->getUser();
        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocationPicture'));
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CollocationPicture entity.
    *
    * @param CollocationPicture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CollocationPicture $entity)
    {
        $form = $this->createForm(new CollocationPictureType(), $entity, array(
            'action' => $this->generateUrl('dash_collocationPicture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }
    /**
     * Edits an existing CollocationPicture entity.
     *
     * @Route("/{id}", name="dash_collocationPicture_update")
     * @Method("PUT")
     * @Template("SlackissBitBundle:CollocationPicture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $current = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('SlackissBitBundle:CollocationPicture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配图片.');
        }

        if($current->getId()!=$entity->getMember()->getId()){
            return $this->redirect($this->generateUrl('dash_collocationPicture'));
        }



        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $current = $this->get('security.context')->getToken()->getUser();
            if($current->getId()===$entity->getMember()->getId()){
                $entity->setModified( new \DateTime());
                $em->flush();

                return $this->redirect($this->generateUrl('dash_collocationPicture_edit', array('id' => $id)));
            }

        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CollocationPicture entity.
     *
     * @Route("/{id}", name="dash_collocationPicture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $current = $this->get('security.context')->getToken()->getUser();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SlackissBitBundle:CollocationPicture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('没找到这个搭配图片.');
            }
            $current = $this->get('security.context')->getToken()->getUser();
            if($current->getId()===$entity->getMember()->getId()){
                $entity->setModified( new \DateTime());
                $entity->setStatus( false);
                $em->flush();
            }

        }

        return $this->redirect($this->generateUrl('dash_collocationPicture'));
    }

    /**
     * Creates a form to delete a CollocationPicture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_collocationPicture_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '禁用','attr'=>[
                'class'=>'btn btn-danger'
            ]))
            ->getForm()
        ;
    }
}
