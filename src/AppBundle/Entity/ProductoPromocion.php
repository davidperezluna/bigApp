<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoPromocion
 *
 * @ORM\Table(name="producto_promocion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoPromocionRepository")
 */
class ProductoPromocion
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
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="municipios")
     */
    protected $producto;


    /**
     * @ORM\ManyToOne(targetEntity="BanerPublicidad", inversedBy="municipios")
     */
    protected $banerPublicidad;


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
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     * @return ProductoPromocion
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
     * Set banerPublicidad
     *
     * @param \AppBundle\Entity\BanerPublicidad $banerPublicidad
     * @return ProductoPromocion
     */
    public function setBanerPublicidad(\AppBundle\Entity\BanerPublicidad $banerPublicidad = null)
    {
        $this->banerPublicidad = $banerPublicidad;

        return $this;
    }

    /**
     * Get banerPublicidad
     *
     * @return \AppBundle\Entity\BanerPublicidad 
     */
    public function getBanerPublicidad()
    {
        return $this->banerPublicidad;
    }
}
