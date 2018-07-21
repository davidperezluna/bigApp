<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amigo
 *
 * @ORM\Table(name="amigo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmigoRepository")
 */
class Amigo
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
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="usuarios")
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="amigos")
     */
    protected $amigo;


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
     * Set usuario
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuario
     *
     * @return Amigo
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
     * Set amigo
     *
     * @param \Mapps\UsuarioBundle\Entity\User $amigo
     *
     * @return Amigo
     */
    public function setAmigo(\Mapps\UsuarioBundle\Entity\User $amigo = null)
    {
        $this->amigo = $amigo;

        return $this;
    }

    /**
     * Get amigo
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getAmigo()
    {
        return $this->amigo;
    }
}
