<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Publicacion
 *
 * @ORM\Table(name="publicacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicacionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Publicacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;


    /**
     * @var string
     *
     * @ORM\Column(name="urlVideoYutube", type="string", length=255, nullable = true)
     */
    private $urlVideoYutube;

    /**
     * @var string
     *
     * @ORM\Column(name="Imagen", type="string", length=255, nullable = true)
     */
    private $imagen;


    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime" , nullable = true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="publicaciones")
     */
    protected $usuarioEmisor;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="publicaciones")
     */
    protected $usuarioReceptor;

    /**
    * @ORM\OneToMany(targetEntity="Comentario", mappedBy="publicacion")
    */
       private $comentarios;

       public function __construct() {
           $this->comentarios = new ArrayCollection();
       }

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
     * Set contenido
     *
     * @param string $contenido
     * @return Publicacion
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }


    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Publicacion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Publicacion
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
     * @return Publicacion
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
     * Add comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     * @return Publicacion
     */
    public function addComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios[] = $comentarios;

        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     */
    public function removeComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set urlVideoYutube
     *
     * @param string $urlVideoYutube
     * @return Publicacion
     */
    public function setUrlVideoYutube($urlVideoYutube)
    {
        $this->urlVideoYutube = $urlVideoYutube;

        return $this;
    }

    /**
     * Get urlVideoYutube
     *
     * @return string
     */
    public function getUrlVideoYutube()
    {
        return $this->urlVideoYutube;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Publicacion
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set usuarioEmisor
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuarioEmisor
     *
     * @return Publicacion
     */
    public function setUsuarioEmisor(\Mapps\UsuarioBundle\Entity\User $usuarioEmisor = null)
    {
        $this->usuarioEmisor = $usuarioEmisor;

        return $this;
    }

    /**
     * Get usuarioEmisor
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getUsuarioEmisor()
    {
        return $this->usuarioEmisor;
    }

    /**
     * Set usuarioReceptor
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuarioReceptor
     *
     * @return Publicacion
     */
    public function setUsuarioReceptor(\Mapps\UsuarioBundle\Entity\User $usuarioReceptor = null)
    {
        $this->usuarioReceptor = $usuarioReceptor;

        return $this;
    }

    /**
     * Get usuarioReceptor
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getUsuarioReceptor()
    {
        return $this->usuarioReceptor;
    }
}
