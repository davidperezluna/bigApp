<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * BanerPublicidad
 *
 * @ORM\Table(name="baner_publicidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BanerPublicidadRepository")
 */
class BanerPublicidad
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="string", length=255)
     */
    private $slogan;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="banersPublicidad")
     */
    protected $empresa;

    /**
     * @ORM\OneToMany(targetEntity="ProductoPromocion", mappedBy="banerPublicidad")
     */
    private $productosPromocion;

    public function __construct() {
        $this->productosPromocion = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return BanerPublicidad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     * @return BanerPublicidad
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return BanerPublicidad
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     * @return BanerPublicidad
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
     * Add productosPromocion
     *
     * @param \AppBundle\Entity\ProductoPromocion $productosPromocion
     * @return BanerPublicidad
     */
    public function addProductosPromocion(\AppBundle\Entity\ProductoPromocion $productosPromocion)
    {
        $this->productosPromocion[] = $productosPromocion;

        return $this;
    }

    /**
     * Remove productosPromocion
     *
     * @param \AppBundle\Entity\ProductoPromocion $productosPromocion
     */
    public function removeProductosPromocion(\AppBundle\Entity\ProductoPromocion $productosPromocion)
    {
        $this->productosPromocion->removeElement($productosPromocion);
    }

    /**
     * Get productosPromocion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductosPromocion()
    {
        return $this->productosPromocion;
    }
}
