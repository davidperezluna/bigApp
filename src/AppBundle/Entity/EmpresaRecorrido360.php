<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaRecorrido360
 *
 * @ORM\Table(name="empresa_recorrido360")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRecorrido360Repository")
 */
class EmpresaRecorrido360
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
     * @ORM\Column(name="urlRecorrido", type="string", length=255)
     */
    private $urlRecorrido;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="recorridos360")
     */
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="Tipo360", inversedBy="recorridos360")
     */
    protected $tipo360;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenRecorrido", type="string", length=255)
     */
    private $imagenRecorrido;


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
     * Set urlRecorrido
     *
     * @param string $urlRecorrido
     * @return EmpresaRecorrido360
     */
    public function setUrlRecorrido($urlRecorrido)
    {
        $this->urlRecorrido = $urlRecorrido;

        return $this;
    }

    /**
     * Get urlRecorrido
     *
     * @return string
     */
    public function getUrlRecorrido()
    {
        return $this->urlRecorrido;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     * @return EmpresaRecorrido360
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
     * Set imagenRecorrido
     *
     * @param string $imagenRecorrido
     * @return EmpresaRecorrido360
     */
    public function setImagenRecorrido($imagenRecorrido)
    {
        $this->imagenRecorrido = $imagenRecorrido;

        return $this;
    }

    /**
     * Get imagenRecorrido
     *
     * @return string
     */
    public function getImagenRecorrido()
    {
        return $this->imagenRecorrido;
    }

    /**
     * Set tipo360
     *
     * @param \AppBundle\Entity\Tipo360 $tipo360
     * @return EmpresaRecorrido360
     */
    public function setTipo360(\AppBundle\Entity\Tipo360 $tipo360 = null)
    {
        $this->tipo360 = $tipo360;

        return $this;
    }

    /**
     * Get tipo360
     *
     * @return \AppBundle\Entity\Tipo360
     */
    public function getTipo360()
    {
        return $this->tipo360;
    }
}
