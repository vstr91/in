<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of FotoController
 *
 * @author Almir
 */
class FotoController extends Controller {
    
    public function cadastrarAction($id_foto){
        $foto = null;
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        
        //verifica se ja existe registro
        $foto = $em->find('SiteBundle:Foto', $id_foto);
        
        //se nao existir, cria novo objeto
        if(is_null($foto)){
            $foto = new \SiteBundle\Entity\Foto();
        }
        
        $form = $this->createForm(\SiteBundle\Form\FotoType::class, $foto);
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            //cadastra ou edita objeto
            
            $em->persist($foto);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_admin_fotos'));
        }
        
        $fotos = $em->getRepository('SiteBundle:Foto')
                ->findAll();
        
        return $this->render('@Site/Admin/Foto/index.html.twig', array(
            'usuario' => $user,
            'fotos' => $fotos,
            'form' => $form->createView()
        ));
        
    }
    
    public function formAction($id_foto){
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager();
        $foto = $em->find('SiteBundle:Foto', $id_foto);
        
        if(is_null($foto)){
            $foto = new \SiteBundle\Entity\Foto();
        }
        
        $form = $this->createForm(\SiteBundle\Form\FotoType::class, $foto);
        
//        $form->bind($request);
        
        return $this->render('@Site/Admin/Foto/form.html.twig',
                array(
                    'form' => $form->createView(),
                    'foto' => $foto
                ));
    }
    
    public function excluirAction($id_foto){
        $foto = null;
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager();
        
        //verifica se ja existe registro
        $foto = $em->find('SiteBundle:Foto', $id_foto);
        
        //se nao existir, cria novo objeto
        if(!is_null($foto)){
            $em->remove($foto);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_admin_fotos'));
            
        } else{
            return new \Symfony\Component\HttpFoundation\Response('Registro não encontrado', 404);
        }
        
    }
    
}
