<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of NoticiaController
 *
 * @author Almir
 */
class PostagemController extends Controller {
    
    public function cadastrarAction($id_postagem){
        $postagem = null;
        
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        
        //verifica se ja existe registro
        $postagem = $em->find('SiteBundle:Postagem', $id_postagem);
        
        //se nao existir, cria novo objeto
        if(is_null($postagem)){
            $postagem = new \SiteBundle\Entity\Postagem();
        }
        
        $form = $this->createForm(\SiteBundle\Form\PostagemType::class, $postagem);
        $form->handleRequest($request);
        
        //die();
        
        if($form->isValid()){
            
            //cadastra ou edita objeto
            $postagem->setSlug($postagem->getTitulo());
            
            $em->persist($postagem);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_admin_postagens'));
        }
        
        $postagens = $em->getRepository('SiteBundle:Postagem')
                ->findAll();
        
        return $this->render('@Site/Admin/Postagem/index.html.twig', array(
            'usuario' => $user,
            'postagens' => $postagens,
            'form' => $form->createView()
        ));
        
    }
    
    public function formAction($id_postagem){
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager();
        $postagem = $em->find('SiteBundle:Postagem', $id_postagem);
        
        if(is_null($postagem)){
            $postagem = new \SiteBundle\Entity\Postagem();
        }
        
        $form = $this->createForm(\SiteBundle\Form\PostagemType::class, $postagem);
        
//        $form->bind($request);
        
        return $this->render('@Site/Admin/Postagem/form.html.twig',
                array(
                    'form' => $form->createView(),
                    'postagem' => $postagem
                ));
    }
    
    public function excluirAction($id_postagem){
        $postagem = null;
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager();
        
        //verifica se ja existe registro
        $postagem = $em->find('SiteBundle:Postagem', $id_postagem);
        
        //se nao existir, cria novo objeto
        if(!is_null($postagem)){
            $em->remove($postagem);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_admin_postagens'));
            
        } else{
            return new \Symfony\Component\HttpFoundation\Response('Registro não encontrado', 404);
        }
        
    }
    
}
