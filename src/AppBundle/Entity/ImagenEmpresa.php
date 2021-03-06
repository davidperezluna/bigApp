<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImagenEmpresa
 *
 * @ORM\Table(name="imagen_empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImagenEmpresaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ImagenEmpresa
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
     * @ORM\Column(name="urlImagen", type="string", length=255)
     */
    private $urlImagen;
     /**
     * @var string
     *
     * @ORM\Column(name="urlImagenEmpresa", type="string", length=255)
     */
    private $urlImagenEmpresa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="IMagenes")
     */
    protected $empresa;


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
     * Set urlImagen
     *
     * @param string $urlImagen
     * @return ImagenEmpresa
     */
    public function setUrlImagen($urlImagen)
    {
        $this->urlImagen = $urlImagen;

        return $this;
    }

    /**
     * Get urlImagen
     *
     * @return string
     */
    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ImagenEmpresa
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     * @return ImagenEmpresa
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
    /**
    * Gets triggered only on insert

    * @ORM\PrePersist
    */
   public function onPrePersist()
   {
       $this->created = new \DateTime("now");
   }
  
    /**
     * Set urlImagenEmpresa
     *
     * @param string $urlImagenEmpresa
     *
     * @return ImagenEmpresa
     */
    public function setUrlImagenEmpresa($urlImagenEmpresa)
    {
        $this->urlImagenEmpresa = $urlImagenEmpresa;

        return $this;
    }

    /**
     * Get urlImagenEmpresa
     *
     * @return string
     */
    public function getUrlImagenEmpresa()
    {
        return $this->urlImagenEmpresa;
    }
}
