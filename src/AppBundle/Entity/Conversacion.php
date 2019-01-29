<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversacion
 *
 * @ORM\Table(name="conversacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConversacionRepository")
 */
class Conversacion
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
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User")
     */
    protected $usuarioUno;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User")
     */
    protected $usuarioDos;



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
     * Set usuarioUno
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuarioUno
     *
     * @return Conversacion
     */
    public function setUsuarioUno(\Mapps\UsuarioBundle\Entity\User $usuarioUno = null)
    {
        $this->usuarioUno = $usuarioUno;

        return $this;
    }

    /**
     * Get usuarioUno
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getUsuarioUno()
    {
        return $this->usuarioUno;
    }

    /**
     * Set usuarioDos
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuarioDos
     *
     * @return Conversacion
     */
    public function setUsuarioDos(\Mapps\UsuarioBundle\Entity\User $usuarioDos = null)
    {
        $this->usuarioDos = $usuarioDos;

        return $this;
    }

    /**
     * Get usuarioDos
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getUsuarioDos()
    {
        return $this->usuarioDos;
    }
}
