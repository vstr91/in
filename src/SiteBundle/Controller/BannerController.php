<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of BannerController
 *
 * @author Almir
 */
class BannerController extends Controller {
    
    public function cadastrarAction($id_banner){
        $banner = null;
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        
        //verifica se ja existe registro
        $banner = $em->find('SiteBundle:Banner', $id_banner);
        
        //se nao existir, cria novo objeto
        if(is_null($banner)){
            $banner = new \SiteBundle\Entity\Banner();
        }
        
        $form = $this->createForm(\SiteBundle\Form\BannerType::class, $banner);
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            //cadastra ou edita objeto
            
            $em->persist($banner);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_admin_banners'));
        }
        
        $banners = $em->getRepository('SiteBundle:Banner')
                ->findAll();
        
        return $this->render('@Site/Admin/Banner/index.html.twig', array(
            'usuario' => $user,
            'banners' => $banners,
            'form' => $form->createView()
        ));
        
    }
    
    public function formAction($id_banner){
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager();
        $banner = $em->find('SiteBundle:Banner', $id_banner);
        
        if(is_null($banner)){
            $banner = new \SiteBundle\Entity\Banner();
        }
        
        $form = $this->createForm(\SiteBundle\Form\BannerType::class, $banner);
        
//        $form->bind($request);
        
        return $this->render('@Site/Admin/Banner/form.html.twig',
                array(
                    'form' => $form->createView(),
                    'banner' => $banner
                ));
    }
    
    public function excluirAction($id_banner){
        $banner = null;
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager();
        
        //verifica se ja existe registro
        $banner = $em->find('SiteBundle:Banner', $id_banner);
        
        //se nao existir, cria novo objeto
        if(!is_null($banner)){
            $em->remove($banner);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_admin_banners'));
            
        } else{
            return new \Symfony\Component\HttpFoundation\Response('Registro não encontrado', 404);
        }
        
    }
    
}
