<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoRepository")
 */
class Pedido
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;


     /**
     * @ORM\ManyToOne(targetEntity="MedioPago", inversedBy="IMagenes")
     */
    protected $medioPago;

    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="IMagenes")
     */
    protected $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="empresas")
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="IMagenes")
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Pedido
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

   

    /**
     * Set medioPago
     *
     * @param \AppBundle\Entity\MedioPago $medioPago
     *
     * @return Pedido
     */
    public function setMedioPago(\AppBundle\Entity\MedioPago $medioPago = null)
    {
        $this->medioPago = $medioPago;

        return $this;
    }

    /**
     * Get medioPago
     *
     * @return \AppBundle\Entity\MedioPago
     */
    public function getMedioPago()
    {
        return $this->medioPago;
    }

    /**
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return Pedido
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
     * Set usuario
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuario
     *
     * @return Pedido
     */
    public function setUsuario(\Mapps\UsuarioBundle\Entity\User $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Pedido
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Pedido
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
}
