<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoImagen
 *
 * @ORM\Table(name="producto_imagen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoImagenRepository")
 */
class ProductoImagen
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
     * @ORM\Column(name="imagen", type="string", length=255)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="urlImagen", type="string", length=255)
     */
    private $urlImagen;

    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="imagenes")
     */
    protected $producto;


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
     * Set imagen
     *
     * @param string $imagen
     * @return ProductoImagen
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
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     * @return ProductoImagen
     */
    public function setProducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \AppBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set urlImagen
     *
     * @param string $urlImagen
     *
     * @return ProductoImagen
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
}
