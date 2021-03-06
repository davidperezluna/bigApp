<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubastaComentario
 *
 * @ORM\Table(name="subasta_comentario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubastaComentarioRepository")
 */
class SubastaComentario
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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="string", length=255)
     */
    private $contenido;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="comentariosSubastas")
     */
    protected $usuarioEmisor;

     /**
     * @ORM\ManyToOne(targetEntity="Subasta", inversedBy="comentariosSubastas")
     */
    protected $subasta;

    


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SubastaComentario
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return SubastaComentario
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set usuarioEmisor
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuarioEmisor
     *
     * @return SubastaComentario
     */
    public function setUsuarioEmisor(\Mapps\UsuarioBundle\Entity\User $usuarioEmisor = null)
    {
        $this->usuarioEmisor = $usuarioEmisor;

        return $this;
    }

    /**
     * Get usuarioEmisor
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getUsuarioEmisor()
    {
        return $this->usuarioEmisor;
    }



    /**
     * Set subasta
     *
     * @param \AppBundle\Entity\Subasta $subasta
     *
     * @return SubastaComentario
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
}
