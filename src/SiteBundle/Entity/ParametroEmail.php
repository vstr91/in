<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SiteBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ParametroEmail
 *
 * @author Almir
 */

/**
 * ParametroEmail
 *
 * @ORM\Entity(repositoryClass="SiteBundle\Entity\Repository\ParametroEmailRepository")
 * @ORM\Table(name="parametro_email")
 * @ORM\HasLifecycleCallbacks()
 */
class ParametroEmail {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="destinatario", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $destinatario;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set destinatario
     *
     * @param string $destinatario
     * @return ParametroEmail
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return string 
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

}
