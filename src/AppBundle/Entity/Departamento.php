<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartamentoRepository")
 */
class Departamento
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
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="indicativo", type="string", length=10)
     */
    private $indicativo;

    /**
     * @ORM\OneToMany(targetEntity="Municipio", mappedBy="departamento")
     */
    private $municipios;

    public function __construct() {
        $this->municipios = new ArrayCollection();
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
     * Set codigo
     *
     * @param string $codigo
     * @return Departamento
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Departamento
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
     * Set indicativo
     *
     * @param string $indicativo
     * @return Departamento
     */
    public function setIndicativo($indicativo)
    {
        $this->indicativo = $indicativo;

        return $this;
    }

    /**
     * Get indicativo
     *
     * @return string
     */
    public function getIndicativo()
    {
        return $this->indicativo;
    }

    /**
     * Add municipios
     *
     * @param \AppBundle\Entity\Municipio $municipios
     * @return Departamento
     */
    public function addMunicipio(\AppBundle\Entity\Municipio $municipios)
    {
        $this->municipios[] = $municipios;

        return $this;
    }

    /**
     * Remove municipios
     *
     * @param \AppBundle\Entity\Municipio $municipios
     */
    public function removeMunicipio(\AppBundle\Entity\Municipio $municipios)
    {
        $this->municipios->removeElement($municipios);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}
