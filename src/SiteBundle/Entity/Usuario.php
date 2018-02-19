<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SiteBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use \FOS\UserBundle\Model\User as BaseUser;

/**
 * Description of Usuario
 *
 * @author Almir
 */

/**
 * Usuario
 *
 * @ORM\Entity(repositoryClass="SiteBundle\Entity\Repository\UsuarioRepository")
 * @ORM\Table(name="usuario")
 * @ORM\HasLifecycleCallbacks()
 */
class Usuario extends BaseUser {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
