<?php

namespace Slackiss\Bundle\BitBundle\Controller\Dash;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Slackiss\Bundle\BitBundle\Entity\Collocation;
use Slackiss\Bundle\BitBundle\Form\CollocationType;

/**
 * Collocation controller.
 *
 * @Route("/dash/collocation")
 */
class CollocationController extends Controller
{

    /**
     * Lists all Collocation entities.
     *
     * @Route("/", name="dash_collocation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page',1);
        $repo = $em->getRepository('SlackissBitBundle:Collocation');
        $current = $this->get('security.context')->getToken()->getUser();
       
            $query = $repo->createQueryBuilder('a')
                ->orderBy('a.state','desc')
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
     * Creates a new Collocation entity.
     *
     * @Route("/", name="dash_collocation_create")
     * @Method("POST")
     * @Template("SlackissBitBundle:Collocation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Collocation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $current = $this->get('security.context')->getToken()->getUser();
            $entity->setMember($current);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dash_collocation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Collocation entity.
     *
     * @param Collocation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Collocation $entity)
    {
        $form = $this->createForm(new CollocationType(), $entity, array(
            'action' => $this->generateUrl('dash_collocation_create'),
            'method' => 'POST',
            'attr'=>array('class'=>'form-horizontal', 'role'=>'form')
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }

    /**
     * Displays a form to create a new Collocation entity.
     *
     * @Route("/new", name="dash_collocation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Collocation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }



    /**
     *publish a Collocation entity.
     *
     * @Route("/publish/{id}", name="dash_publish")
     * @Method("GET")
     */
    public function publishAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }
        $current = $this->get('security.context')->getToken()->getUser();


        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocation'));
        }
        $entity->setModified( new \DateTime());
        $entity->setState(Collocation::STATE_VERIFIED);
        $em->flush();
        return $this->redirect($this->generateUrl('dash_collocation'));
    }


    /**
     *enable a Collocation entity.
     *
     * @Route("/enable/{id}", name="dash_enable_collocation")
     * @Method("GET")
     */
    public function enableAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }

        $entity->setEnabled(true);
        $entity->setModified( new \DateTime());
        $em->flush();
        return $this->redirect($this->generateUrl('dash_collocation'));
    }
    /**
     *enable a Collocation entity.
     *
     * @Route("/disable/{id}", name="dash_disable_collocation")
     * @Method("GET")
     */
    public function disableAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }

        $entity->setEnabled(false);
        $entity->setModified( new \DateTime());
        $em->flush();
        return $this->redirect($this->generateUrl('dash_collocation'));
    }
    /**
     * Finds and displays a Collocation entity.
     *
     * @Route("/{id}", name="dash_collocation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }
        $current = $this->get('security.context')->getToken()->getUser();


        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocation'));
        }


        $repoCollocationPlu = $em->getRepository('SlackissBitBundle:CollocationPlu');
        $collocationPlus = $repoCollocationPlu->createQueryBuilder('a')
            ->orderBy('a.modified','desc')
            ->where('a.status = :status')
            ->andWhere('a.member = :member')
          //  ->andWhere('a.enabled = :enabled')
            ->andWhere('a.collocation = :collocation')
            ->setParameters(array('status'=>true,'member'=>$current->getId(),'collocation'=>$entity))
            ->getQuery()
            ->getResult();

        $repoCollocationPiture = $em->getRepository('SlackissBitBundle:CollocationPicture');
        $collocationPictures = $repoCollocationPiture->createQueryBuilder('a')
            ->orderBy('a.modified','desc')
            ->where('a.status = :status')
            ->andWhere('a.member = :member')
          //  ->andWhere('a.enabled = :enabled')
            ->andWhere('a.collocation = :collocation')
            ->setParameters(array('status'=>true,'member'=>$current->getId(),'collocation'=>$entity))
            ->getQuery()
            ->getResult();


        $deleteForm = $this->createDeleteForm($id);

        return array(
            'collocationPlus'=>$collocationPlus,
            'collocationPictures'=>$collocationPictures,
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Collocation entity.
     *
     * @Route("/{id}/edit", name="dash_collocation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }

        $current = $this->get('security.context')->getToken()->getUser();
        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocation'));
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
    * Creates a form to edit a Collocation entity.
    *
    * @param Collocation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Collocation $entity)
    {
        $form = $this->createForm(new CollocationType(true), $entity, array(
            'action' => $this->generateUrl('dash_collocation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '保存','attr'=>[
            'class'=>'btn btn-primary'
        ]));

        return $form;
    }
    /**
     * Edits an existing Collocation entity.
     *
     * @Route("/{id}", name="dash_collocation_update")
     * @Method("PUT")
     * @Template("SlackissBitBundle:Collocation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配');
        }
        $current = $this->get('security.context')->getToken()->getUser();
        if($current->getId()!==$entity->getMember()->getId()){
            return  $this->redirect($this->generateUrl('dash_collocation'));
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $current = $this->get('security.context')->getToken()->getUser();
            if($current->getId()===$entity->getMember()->getId()){

                if($entity->getState()===Collocation::STATE_PUBLISHED){
                    $entity->setState(Collocation::STATE_VERIFIED);
                }
                $entity->setModified( new \DateTime());
                $em->flush();
            }


            return $this->redirect($this->generateUrl('dash_collocation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Collocation entity.
     *
     * @Route("/{id}", name="dash_collocation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('没找到这个搭配.');
            }
            $current = $this->get('security.context')->getToken()->getUser();
            if($current->getId()===$entity->getMember()->getId()){
                $entity->setModified( new \DateTime());
                $entity->setStatus( false);
                $em->flush();
            }
            }


        return $this->redirect($this->generateUrl('dash_collocation'));
    }

    /**
     * Creates a form to delete a Collocation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_collocation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '删除','attr'=>[
                'class'=>'btn btn-danger'
            ]))
            ->getForm()
        ;
    }
}
