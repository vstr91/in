<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $banners = $em->getRepository('SiteBundle:Banner')
                ->listarTodos(5);
        
        $fotos = $em->getRepository('SiteBundle:Foto')
                ->listarTodos(10);
        
        return $this->render('@Site/Page/index.html.twig', array(
            'banners' => $banners,
            'fotos' => $fotos
        ));
    }
    
    public function centralAction()
    {
        return $this->render('@Site/Page/central.html.twig');
    }
    
    public function processarContatoAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        
        $myRequest = $request->request;
        
        $nome = $myRequest->get('nome');
        $email = $myRequest->get('email');
        $assunto = $myRequest->get('assunto');
        $mensagem = $myRequest->get('mensagem');
        
        $parametros = $em->getRepository('SiteBundle:ParametroEmail')
                ->findOneBy(array('id' => 1));
        
        if($nome && $email && $assunto && $mensagem){
            $email = \Swift_Message::newInstance()
                        ->setSubject("Novo Contato: ".$assunto)
                        ->setFrom($parametros->getDestinatario())
                        ->setTo($parametros->getDestinatario())
                        ->setBody($this->renderView('@Site/Component/email.html.twig', 
                                array(
                                    'nome' => $nome,
                                    'email' => $email,
                                    'assunto' => $assunto,
                                    'mensagem' => $mensagem
                                )
                        ))
                        ->setContentType("text/html");
            
            $this->get('mailer')->send($email);
            
            return new \Symfony\Component\HttpFoundation\Response('ok', 200);
        } else{
            return new \Symfony\Component\HttpFoundation\Response('nok');
        }
    }
    
    public function integraAction()
    {
        return $this->render('@Site/Page/integra.html.twig');
    }
    
    public function anaAction()
    {
        return $this->render('@Site/Page/ana.html.twig');
    }
    
    public function especialidadesAction()
    {
        return $this->render('@Site/Page/especialidades.html.twig');
    }
    
    public function blogAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $postagens = $em->getRepository('SiteBundle:Postagem')
                ->findAll();
        
        return $this->render('@Site/Page/blog.html.twig', array(
            'postagens' => $postagens
        ));
    }
    
    public function contatoAction()
    {
        return $this->render('@Site/Page/contato.html.twig');
    }
    
    public function blogPostagemAction($slug)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $postagem = $em->getRepository('SiteBundle:Postagem')
                ->findOneBy(array('slug' => $slug));
        
        return $this->render('@Site/Page/blog-postagem.html.twig', array(
            'postagem' => $postagem
        ));
    }
    
    public function fotosAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $fotos = $em->getRepository('SiteBundle:Foto')
                ->findAll();
        
        return $this->render('@Site/Page/fotos.html.twig', array(
            'fotos' => $fotos
        ));
    }
    
}
