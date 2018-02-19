<?php

namespace SiteBundle\Controller;

use SiteBundle\Form\PostagemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {

    public function indexAction() {

        $user = $this->getUser();

        return $this->render('@Site/Admin/index.html.twig', array(
                    'usuario' => $user
        ));
    }

    public function indexPostagemAction() {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $postagemType = new PostagemType();
        $formPostagem = $this->createForm(PostagemType::class);

        $postagens = $em->getRepository('SiteBundle:Postagem')
                ->findAll();

        return $this->render('@Site/Admin/Postagem/index.html.twig', array(
                    'usuario' => $user,
                    'postagens' => $postagens,
                    'form' => $formPostagem->createView()
        ));
    }

    public function indexFotoAction() {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $formFoto = $this->createForm(\SiteBundle\Form\FotoType::class);

        $fotos = $em->getRepository('SiteBundle:Foto')
                ->findAll();

        return $this->render('@Site/Admin/Foto/index.html.twig', array(
                    'usuario' => $user,
                    'fotos' => $fotos,
                    'form' => $formFoto->createView()
        ));
    }

    public function indexBannerAction() {

        $em = $this->getDoctrine()->getManager();
        
        $user = $this->getUser();

        $formBanner = $this->createForm(\SiteBundle\Form\BannerType::class);

        $banners = $em->getRepository('SiteBundle:Banner')
                ->findAll();

        return $this->render('@Site/Admin/Banner/index.html.twig', array(
                    'usuario' => $user,
                    'banners' => $banners,
                    'form' => $formBanner->createView()
        ));
    }
    
    public function indexParametroEmailAction() {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        
        $param = $em->getRepository('SiteBundle:ParametroEmail')
                ->findOneBy(array('id' => 1));

        $paramType = new ParametroEmailType();
        $formParam = $this->createForm($paramType, $param);

        return $this->render('@Site/Admin/ParametroEmail/form.html.twig', array(
                    'usuario' => $user,
                    'parametros' => $param,
                    'form' => $formParam->createView()
        ));
    }
    
    function mysql_escape_mimic($inp) { 
        if(is_array($inp)) 
            return array_map(__METHOD__, $inp); 

        if(!empty($inp) && is_string($inp)) { 
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
        } 

        return $inp; 
    } 
    
}
