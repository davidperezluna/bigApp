<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaRedes
 *
 * @ORM\Table(name="empresa_redes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRedesRepository")
 */
class EmpresaRedes
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
     * @ORM\Column(name="urlRedSocial", type="string", length=255)
     */
    private $urlRedSocial;
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="redes")
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
     * Set nombre
     *
     * @param string $nombre
     * @return EmpresaRedes
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
     * Set urlRedSocial
     *
     * @param string $urlRedSocial
     * @return EmpresaRedes
     */
    public function setUrlRedSocial($urlRedSocial)
    {
        $this->urlRedSocial = $urlRedSocial;

        return $this;
    }

    /**
     * Get urlRedSocial
     *
     * @return string 
     */
    public function getUrlRedSocial()
    {
        return $this->urlRedSocial;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     * @return EmpresaRedes
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
