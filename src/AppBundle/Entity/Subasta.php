<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subasta
 *
 * @ORM\Table(name="subasta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubastaRepository")
 */
class Subasta
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="peticion", type="text")
     */
    private $peticion;

     /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="subastas")
     */
    protected $usuario;
    
    /**
     * @ORM\ManyToOne(targetEntity="EmpresaSubCategoria", inversedBy="subastas")
     */
    protected $categoria;

     /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="subastas")
     */
    protected $empresa;

     /**
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="subastas")
     */
    protected $municipio;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Subasta
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
     * Set peticion
     *
     * @param string $peticion
     *
     * @return Subasta
     */
    public function setPeticion($peticion)
    {
        $this->peticion = $peticion;

        return $this;
    }

    /**
     * Get peticion
     *
     * @return string
     */
    public function getPeticion()
    {
        return $this->peticion;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\EmpresaSubCategoria $categoria
     *
     * @return Subasta
     */
    public function setCategoria(\AppBundle\Entity\EmpresaSubCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\EmpresaSubCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set usuario
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuario
     *
     * @return Subasta
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
     * @return Subasta
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Subasta
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
