<?php

namespace Mapps\UsuarioBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;


    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=255)
     */
    private $celular;

      /**
     * @var string
     *
     * @ORM\Column(name="fotoPerfil", type="string", length=255)
     */
    private $fotoPerfil;

      /**
     * @var string
     *
     * @ORM\Column(name="fotoPortada", type="string", length=255)
     */
    private $fotoPortada;

     /**
     * @var string
     *
     * @ORM\Column(name="rolePersona", type="string", length=255, nullable = true)
     */
    private $rolePersona;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="date" , nullable = true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Publicacion", mappedBy="usuarioReceptor")
     */
    private $publicaciones;


      /**
    * Gets triggered only on insert
    * @ORM\PrePersist
    */


    public function __construct()
    {
        parent::__construct();
        // your own logic
       
    }

    /**
    * Gets triggered only on insert
    * @ORM\PrePersist
    */
   public function onPrePersist()
   {
       $this->createdAt = new \DateTime("now");
   }

   /**
    * Gets triggered every time on update
    * @ORM\PreUpdate
    */
   public function onPreUpdate()
   {
       $this->updatedAt = new \DateTime("now");
   }


    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return User
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return User
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return User
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set fotoPerfil
     *
     * @param string $fotoPerfil
     *
     * @return User
     */
    public function setFotoPerfil($fotoPerfil)
    {
        $this->fotoPerfil = $fotoPerfil;

        return $this;
    }

    /**
     * Get fotoPerfil
     *
     * @return string
     */
    public function getFotoPerfil()
    {
        return $this->fotoPerfil;
    }

    /**
     * Set fotoPortada
     *
     * @param string $fotoPortada
     *
     * @return User
     */
    public function setFotoPortada($fotoPortada)
    {
        $this->fotoPortada = $fotoPortada;

        return $this;
    }

    /**
     * Get fotoPortada
     *
     * @return string
     */
    public function getFotoPortada()
    {
        return $this->fotoPortada;
    }

    /**
     * Set rolePersona
     *
     * @param string $rolePersona
     *
     * @return User
     */
    public function setRolePersona($rolePersona)
    {
        $this->rolePersona = $rolePersona;

        return $this;
    }

    /**
     * Get rolePersona
     *
     * @return string
     */
    public function getRolePersona()
    {
        return $this->rolePersona;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    

    /**
     * Add publicacione
     *
     * @param \AppBundle\Entity\Publicacion $publicacione
     *
     * @return User
     */
    public function addPublicacione(\AppBundle\Entity\Publicacion $publicacione)
    {
        $this->publicaciones[] = $publicacione;

        return $this;
    }

    /**
     * Remove publicacione
     *
     * @param \AppBundle\Entity\Publicacion $publicacione
     */
    public function removePublicacione(\AppBundle\Entity\Publicacion $publicacione)
    {
        $this->publicaciones->removeElement($publicacione);
    }

    /**
     * Get publicaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublicaciones()
    {
        return $this->publicaciones;
    }

}
