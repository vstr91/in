<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SiteBundle\Entity;

/**
 * Description of Banner
 *
 * @author Almir
 */

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Banner
 *
 * @ORM\Entity(repositoryClass="SiteBundle\Entity\Repository\BannerRepository")
 * @ORM\Table(name="banner")
 * @ORM\HasLifecycleCallbacks()
 */
class Banner {
    
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
     * @ORM\Column(name="imagem", type="string", length=50, nullable=true)
     */
    private $imagem;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagemMob", type="string", length=50, nullable=true)
     */
    private $imagemMob;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="link", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $link;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    private $temp;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $fileMob;
    
    private $tempMob;
    
    /**
     *
     * @ORM\Column(name="dataCadastro", type="datetime")
     */
    private $dataCadastro;
    
    /**
     *
     * @ORM\Column(name="ultimaAlteracao", type="datetime")
     */
    private $ultimaAlteracao;
    
    ################## INICIO METODOS MANIPULACAO IMAGENS ###################
    
    public function getAbsolutePath()
    {
        return null === $this->imagem
            ? null
            : $this->getUploadRootDir().'/'.$this->imagem;
    }

    public function getWebPath()
    {
        return null === $this->imagem
            ? null
            : $this->getUploadDir().'/'.$this->imagem;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/banner';
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->imagem)) {
            // store the old name to delete after the update
            $this->temp = $this->imagem;
            $this->imagem = null;
        } else {
            $this->imagem = 'initial';
        }
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->imagem = $filename.'.'.$this->getFile()->guessExtension();
        }
        
        if (null !== $this->getFileMob()) {
            // do whatever you want to generate a unique name
            $filenameMob = sha1(uniqid(mt_rand(), true));
            $this->imagemMob = $filenameMob.'.'.$this->getFileMob()->guessExtension();
        }
        
        if($this->getDataCadastro() == null){
            $this->setDataCadastro(new \DateTime());
        }
        
        $this->setUltimaAlteracao(new \DateTime());
        
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile() && null === $this->getFileMob()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        
        if(null !== $this->getFile()){
            $this->getFile()->move($this->getUploadRootDir(), $this->imagem);
        }
        
        if(null !== $this->getFileMob()){
            $this->getFileMob()->move($this->getUploadRootDirMob(), $this->imagemMob);
        }
        
        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
        
        // check if we have an old image
        if (isset($this->tempMob)) {
            // delete the old image
            unlink($this->getUploadRootDirMob().'/'.$this->tempMob);
            // clear the temp image path
            $this->tempMob = null;
        }
        $this->fileMob = null;
        
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
        
        if ($fileMob = $this->getAbsolutePathMob()) {
            unlink($fileMob);
        }
        
    }
    
    ################## FIM METODOS MANIPULACAO IMAGENS ###################
    
    ################## INICIO METODOS MANIPULACAO IMAGENS MOB ###################
    
    public function getAbsolutePathMob()
    {
        return null === $this->imagemMob
            ? null
            : $this->getUploadRootDirMob().'/'.$this->imagemMob;
    }

    public function getWebPathMob()
    {
        return null === $this->imagemMob
            ? null
            : $this->getUploadDirMob().'/'.$this->imagemMob;
    }

    protected function getUploadRootDirMob()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDirMob();
    }

    protected function getUploadDirMob()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/banner';
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFileMob(UploadedFile $fileMob = null)
    {
        $this->fileMob = $fileMob;
        // check if we have an old image path
        if (isset($this->imagemMob)) {
            // store the old name to delete after the update
            $this->tempMob = $this->imagemMob;
            $this->imagemMob = null;
        } else {
            $this->imagemMob = 'initial';
        }
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFileMob()
    {
        return $this->fileMob;
    }
    
    ################## FIM METODOS MANIPULACAO IMAGENS MOB ###################
    

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
     * Set imagem
     *
     * @param string $imagem
     *
     * @return Banner
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get imagem
     *
     * @return string
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set dataCadastro
     *
     * @param \DateTime $dataCadastro
     *
     * @return Banner
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return \DateTime
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set ultimaAlteracao
     *
     * @param \DateTime $ultimaAlteracao
     *
     * @return Banner
     */
    public function setUltimaAlteracao($ultimaAlteracao)
    {
        $this->ultimaAlteracao = $ultimaAlteracao;

        return $this;
    }

    /**
     * Get ultimaAlteracao
     *
     * @return \DateTime
     */
    public function getUltimaAlteracao()
    {
        return $this->ultimaAlteracao;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Banner
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set imagemMob
     *
     * @param string $imagemMob
     * @return Banner
     */
    public function setImagemMob($imagemMob)
    {
        $this->imagemMob = $imagemMob;
    
        return $this;
    }

    /**
     * Get imagemMob
     *
     * @return string 
     */
    public function getImagemMob()
    {
        return $this->imagemMob;
    }
}
