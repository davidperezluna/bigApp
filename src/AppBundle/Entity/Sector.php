<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sector
 *
 * @ORM\Table(name="sector")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SectorRepository")
 */
class Sector
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="urlIcono", type="string", length=255)
     */
    private $urlIcono = "iconoDefault.ico" ;


    /**
     * @ORM\OneToMany(targetEntity="EmpresaSector", mappedBy="sector")
     */
    private $empresasSectores;

    public function __construct() {
        $this->empresasSectores = new ArrayCollection();
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
     * @return Sector
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
     * Set activo
     *
     * @param boolean $activo
     * @return Sector
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
     * Set urlIcono
     *
     * @param string $urlIcono
     * @return Sector
     */
    public function setUrlIcono($urlIcono)
    {
        $this->urlIcono = $urlIcono;

        return $this;
    }

    /**
     * Get urlIcono
     *
     * @return string
     */
    public function getUrlIcono()
    {
        return $this->urlIcono;
    }

    /**
     * Add empresasSectores
     *
     * @param \AppBundle\Entity\EmpresaSector $empresasSectores
     * @return Sector
     */
    public function addEmpresasSectore(\AppBundle\Entity\EmpresaSector $empresasSectores)
    {
        $this->empresasSectores[] = $empresasSectores;

        return $this;
    }

    /**
     * Remove empresasSectores
     *
     * @param \AppBundle\Entity\EmpresaSector $empresasSectores
     */
    public function removeEmpresasSectore(\AppBundle\Entity\EmpresaSector $empresasSectores)
    {
        $this->empresasSectores->removeElement($empresasSectores);
    }

    /**
     * Get empresasSectores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresasSectores()
    {
        return $this->empresasSectores;
    }
}
