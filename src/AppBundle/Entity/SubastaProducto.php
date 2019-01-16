<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubastaProducto
 *
 * @ORM\Table(name="subasta_producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubastaProductoRepository")
 */
class SubastaProducto
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
     * @ORM\ManyToOne(targetEntity="Subasta", inversedBy="comentariosSubastas")
     */
    protected $subasta;

     /**
     * @ORM\ManyToOne(targetEntity="Producto")
     */
    protected $producto;

     /**
     * @ORM\ManyToOne(targetEntity="Empresa")
     */
    protected $empresa;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subasta
     *
     * @param \AppBundle\Entity\Subasta $subasta
     *
     * @return SubastaProducto
     */
    public function setSubasta(\AppBundle\Entity\Subasta $subasta = null)
    {
        $this->subasta = $subasta;

        return $this;
    }

    /**
     * Get subasta
     *
     * @return \AppBundle\Entity\Subasta
     */
    public function getSubasta()
    {
        return $this->subasta;
    }

    /**
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return SubastaProducto
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
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return SubastaProducto
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
}
