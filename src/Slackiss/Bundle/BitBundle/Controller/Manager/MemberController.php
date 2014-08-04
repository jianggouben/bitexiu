<?php

namespace Slackiss\Bundle\BitBundle\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Slackiss\Bundle\BitBundle\Entity\Member;
use Slackiss\Bundle\BitBundle\Form\MemberType;

/**
 * Member controller.
 *
 * @Route("/manager/member")
 */
class MemberController extends Controller
{

    /**
     * Lists all Member entities.
     *
     * @Route("/", name="member_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param =  array('nav_active'=>'nav_setting');

        $repo = $em->getRepository('SlackissBitBundle:Member');
        $query = $repo->createQueryBuilder('s')
                      ->orderBy('s.id','desc')
                      ->getQuery();
        $page = $request->query->get('page',1);
        $entities = $this->get('knp_paginator')->paginate($query,$page,50);
        $param['entities'] = $entities;
        return $param;


    }
    /**
     * Creates a new Member entity.
     *
     * @Route("/", name="member_create")
     * @Method("POST")
     * @Template("SlackissBitBundle:Manager/Member:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $param =  array('nav_active'=>'nav_setting');
        $userManager = $this->get('fos_user.user_manager');
        $member = $userManager->createUser();
        $form = $this->getNewForm($member);
        $form->handleRequest($request);
        if($form->isValid()){
            if(!$member->hasRole('ROLE_USER')){
                $member->addRole('ROLE_USER');
            }

            $userManager->updateUser($member);
            $this->get('session')->getFlashBag()->add('success','创建成功');
            return $this->redirect($this->generateUrl('member_list'));
        }
        $param['entity'] = $member;
        $param['form']   = $form->createView();
        return $param;

    }

    /**
     * Creates a form to create a Member entity.
     *
     * @param Member $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function getNewForm($member)
    {
        $type = new MemberType();
        $form = $this->createForm($type,$member,[
            'method'=>'POST',
            'action'=>$this->generateUrl('member_create')
        ]);
        return $form;

    }

    /**
     * Displays a form to create a new Member entity.
     *
     * @Route("/new", name="member_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $param =  array('nav_active'=>'nav_setting');

        $userManager = $this->get('fos_user.user_manager');
        $member = $userManager->createUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->getNewForm($member);
        $param['entity'] = $member;
        $param['form']   = $form->createView();
        return $param;

    }



    /**
     * Displays a form to edit an existing Member entity.
     *
     * @Route("/{id}/edit", name="member_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request,$id)
    {
        $param = array('nav_active'=>'nav_setting');
        $em = $this->getDoctrine()->getManager();
        $current = $this->get('security.context')->getToken()->getUser();

        $repo = $em->getRepository('SlackissBitBundle:Member');
        $member = $repo->find($id);
        if($member){
            $userManager = $this->get('fos_user.user_manager');
            $member=$userManager->findUserByEmail($member->getEmail());
            if($member){
                $param['form'] = $this->getEditForm($member)->createView();
                $param['entity'] = $member;
                return $param;
            }
        }
        $this->get('session')->getFlashBag()->add('warning','没有找到这个员工');
        return $this->redirect($this->generateUrl('member_list'));
    }

    /**
    * Creates a form to edit a Member entity.
    *
    * @param Member $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function getEditForm($member)
    {
        $type = new MemberType(true);
        $form = $this->createForm($type,$member,[
            'method'=>'PUT',
            'action'=>$this->generateUrl('member_update',['id'=>$member->getId()])
        ]);
        return $form;

    }
    /**
     * Edits an existing Member entity.
     *
     * @Route("/update/{id}", name="member_update")
     * @Method("PUT")
     * @Template("SlackissBitBundle:Manager\Member:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $param =  array('nav_active'=>'nav_setting');
        $em = $this->getDoctrine()->getManager();
        $current = $this->get('security.context')->getToken()->getUser();

        $repo = $em->getRepository('SlackissBitBundle:Member');
        $member = $repo->find($id);
        if($member){
            $userManager = $this->get('fos_user.user_manager');
            $member=$userManager->findUserByEmail($member->getEmail());
            if($member){
                $form = $this->getEditForm($member);
                $form->handleRequest($request);
                if($form->isValid()){
                    $userManager->updateUser($member);
                    $this->get('session')->getFlashBag()->add('success','保存成功');
                    return $this->redirect($this->generateUrl('member_edit',['id'=>$member->getId()]));
                }
                $param['form'] = $form->createView();
                $param['entity'] = $member;
                return $param;
            }
        }
        $this->get('session')->getFlashBag()->add('warning','没有找到这个员工');
        return $this->redirect($this->generateUrl('member_list'));
    }
    /**
     * Deletes a Member entity.
     *
     * @Route("/delete/{id}", name="member_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $param =  array('nav_active'=>'nav_setting');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('SlackissBitBundle:Member');
        $member = $repo->find($id);
        if($member){
            $userManager = $this->get('fos_user.user_manager');
            $member = $userManager->findUserByEmail($member->getEmail());
            if($member){
                $member->setEnabled(false);
                $userManager->updateUser($member);
            }
        }
        $this->get('session')->getFlashBag()->add('success','禁用成功');
        return $this->redirect($this->generateUrl('member_list'));

    }

    /**
     * @Route("/enable/{id}",name="member_enable")
     * @Method({"GET"})
     * @Template()
     */
    public function enableAction(Request $request,$id)
    {
        $param =  array('nav_active'=>'nav_setting');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('SlackissBitBundle:Member');
        $member = $repo->find($id);
        if($member){
            $userManager = $this->get('fos_user.user_manager');
            $member = $userManager->findUserByEmail($member->getEmail());
            if($member){
                $member->setEnabled(true);
                $userManager->updateUser($member);
            }
        }
        $this->get('session')->getFlashBag()->add('success','启用成功');
        return $this->redirect($this->generateUrl('member_list'));
    }


}
