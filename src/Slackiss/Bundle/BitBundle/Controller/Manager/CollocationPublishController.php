<?php

namespace Slackiss\Bundle\BitBundle\Controller\Manager;

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
 * @Route("/manager/collocation")
 */
class CollocationPublishController extends Controller
{

    /**
     * Lists all Collocation entities.
     *
     * @Route("/", name="manager_collocation")
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

                ->setParameters(array('status'=>true))
                ->getQuery();
  
        $entities = $this->get('knp_paginator')->paginate($query,$page,50);

        return array(
            'entities' => $entities,
        );
    }





    /**
     *publish a Collocation entity.
     *
     * @Route("/publish/{id}", name="manager_collocation_publish")
     * @Method("GET")
     */
    public function publishAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }

        $entity->setModified( new \DateTime());
        $entity->setState(Collocation::STATE_PUBLISHED);
        $em->flush();
        return $this->redirect($this->generateUrl('manager_collocation'));
    }
    /**
     *publish a Collocation entity.
     *
     * @Route("/disablePublish/{id}", name="manager_collocation_disable_publish")
     * @Method("GET")
     */
    public function disablePublishAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SlackissBitBundle:Collocation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('没找到这个搭配.');
        }


        $entity->setModified( new \DateTime());
        $entity->setState(Collocation::STATE_VERIFIED);
        $em->flush();
        return $this->redirect($this->generateUrl('manager_collocation'));
    }

    /**
     *enable a Collocation entity.
     *
     * @Route("/enable/{id}", name="manager_enable_collocation")
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
        return $this->redirect($this->generateUrl('manager_collocation'));
    }
    /**
     *enable a Collocation entity.
     *
     * @Route("/disable/{id}", name="manager_disable_collocation")
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
        return $this->redirect($this->generateUrl('manager_collocation'));
    }
    /**
     * Finds and displays a Collocation entity.
     *
     * @Route("/{id}", name="manager_collocation_show")
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



        $repoCollocationPlu = $em->getRepository('SlackissBitBundle:CollocationPlu');
        $collocationPlus = $repoCollocationPlu->createQueryBuilder('a')
            ->orderBy('a.modified','desc')
            ->where('a.status = :status')

            ->andWhere('a.collocation = :collocation')
            ->setParameters(array('status'=>true,'collocation'=>$entity))
            ->getQuery()
            ->getResult();

        $repoCollocationPiture = $em->getRepository('SlackissBitBundle:CollocationPicture');
        $collocationPictures = $repoCollocationPiture->createQueryBuilder('a')
            ->orderBy('a.modified','desc')
            ->where('a.status = :status')

            ->andWhere('a.collocation = :collocation')
            ->setParameters(array('status'=>true,'collocation'=>$entity))
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
     * Deletes a Collocation entity.
     *
     * @Route("/{id}", name="manager_collocation_delete")
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


                $entity->setModified( new \DateTime());
                $entity->setStatus( false);
                $em->flush();

            }


        return $this->redirect($this->generateUrl('manager_collocation'));
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
            ->setAction($this->generateUrl('manager_collocation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '删除','attr'=>[
                'class'=>'btn btn-danger'
            ]))
            ->getForm()
        ;
    }
}
