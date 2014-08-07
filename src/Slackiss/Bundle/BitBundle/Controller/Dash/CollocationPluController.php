<?php

namespace Slackiss\Bundle\BitBundle\Controller\Dash;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Slackiss\Bundle\BitBundle\Entity\CollocationPlu;
use Slackiss\Bundle\BitBundle\Form\CollocationPluType;

/**
 * CollocationPlu controller.
 *
 * @Route("/dash/collocationPlu")
 */
class CollocationPluController extends Controller
{

    /**
     * Lists all CollocationPlu entities.
     *
     * @Route("/", name="dash_collocationPlu")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page',1);
        $repo = $em->getRepository('SlackissBitBundle:CollocationPlu');
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
     * Creates a new CollocationPlu entity.
     *
     * @Route("/", name="dash_collocationPlu_create")
     * @Method("POST")
     * @Template("SlackissBitBundle:CollocationPlu:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CollocationPlu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $current = $this->get('security.context')->getToken()->getUser();
            $entity->setMember($current);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dash_collocationPlu_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CollocationPlu entity.
     *
     * @param CollocationPlu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CollocationPlu $entity)
    {
        $form = $this->createForm(new CollocationPluType(), $entity, array(
            'action' => $this->generateUrl('dash_collocationPlu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }

    /**
     * Displays a form to create a new CollocationPlu entity.
     *
     * @Route("/new", name="dash_collocationPlu_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CollocationPlu();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     *enable a Collocation entity.
     *
     * @Route("/enable/{id}", name="dash_enable_collocationPlu")
     * @Method("GET")
     */
    public function enableAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPlu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配元素.');
        }
        $current = $this->get('security.context')->getToken()->getUser();


        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocationPlu'));
        }
        $entity->setEnabled(true);
        $entity->setModified( new \DateTime());
        $em->flush();
        return $this->redirect($this->generateUrl('dash_collocationPlu'));
    }
    /**
     *enable a Collocation entity.
     *
     * @Route("/disable/{id}", name="dash_disable_collocationPlu")
     * @Method("GET")
     */


    public function disableAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPlu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配元素.');
        }
        $current = $this->get('security.context')->getToken()->getUser();


        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocationPlu'));
        }

        $entity->setEnabled(false);
        $entity->setModified( new \DateTime());
        $em->flush();
        return $this->redirect($this->generateUrl('dash_collocationPlu'));
    }



    /**
     * Finds and displays a CollocationPlu entity.
     *
     * @Route("/{id}", name="dash_collocationPlu_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPlu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配元素.');
        }

        $current = $this->get('security.context')->getToken()->getUser();


        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocationPlu'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CollocationPlu entity.
     *
     * @Route("/{id}/edit", name="dash_collocationPlu_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPlu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配元素.');
        }
        $current = $this->get('security.context')->getToken()->getUser();


        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocationPlu'));
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
    * Creates a form to edit a CollocationPlu entity.
    *
    * @param CollocationPlu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CollocationPlu $entity)
    {
        $form = $this->createForm(new CollocationPluType(true), $entity, array(
            'action' => $this->generateUrl('dash_collocationPlu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }
    /**
     * Edits an existing CollocationPlu entity.
     *
     * @Route("/{id}", name="dash_collocationPlu_update")
     * @Method("PUT")
     * @Template("SlackissBitBundle:CollocationPlu:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:CollocationPlu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配元素.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $current = $this->get('security.context')->getToken()->getUser();
            if($current->getId()===$entity->getMember()->getId()){
                $entity->setModified( new \DateTime());
                $em->flush();
            }


            return $this->redirect($this->generateUrl('dash_collocationPlu_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CollocationPlu entity.
     *
     * @Route("/{id}", name="dash_collocationPlu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SlackissBitBundle:CollocationPlu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('没找到这个搭配元素.');
            }
            $current = $this->get('security.context')->getToken()->getUser();
            if($current->getId()===$entity->getMember()->getId()){
                $entity->setModified( new \DateTime());
                $entity->setStatus( false);
                $em->flush();
            }

        }

        return $this->redirect($this->generateUrl('dash_collocationPlu'));
    }

    /**
     * Creates a form to delete a CollocationPlu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_collocationPlu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '删除','attr'=>[
                'class'=>'btn btn-danger'
            ]))
            ->getForm()
        ;
    }
}
