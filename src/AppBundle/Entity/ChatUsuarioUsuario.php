<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatUsuarioUsuario
 *
 * @ORM\Table(name="chat_usuario_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChatUsuarioUsuarioRepository")
 */
class ChatUsuarioUsuario
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
     * @ORM\Column(name="mensaje", type="text")
     */
    private $mensaje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="chats")
     */
    protected $usuario;


    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="chats")
     */
    protected $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="Conversacion", inversedBy="empresas")
     */
    protected $conversacion;


    /**
     * @var bool
     *
     * @ORM\Column(name="visto", type="boolean")
     */
    private $visto = false;




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
     * Set mensaje
     *
     * @param string $mensaje
     *
     * @return ChatUsuarioUsuario
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ChatUsuarioUsuario
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
     * Set visto
     *
     * @param boolean $visto
     *
     * @return ChatUsuarioUsuario
     */
    public function setVisto($visto)
    {
        $this->visto = $visto;

        return $this;
    }

    /**
     * Get visto
     *
     * @return boolean
     */
    public function getVisto()
    {
        return $this->visto;
    }

    /**
     * Set conversacion
     *
     * @param \AppBundle\Entity\Conversacion $conversacion
     *
     * @return ChatUsuarioUsuario
     */
    public function setConversacion(\AppBundle\Entity\Conversacion $conversacion = null)
    {
        $this->conversacion = $conversacion;

        return $this;
    }

    /**
     * Get conversacion
     *
     * @return \AppBundle\Entity\Conversacion
     */
    public function getConversacion()
    {
        return $this->conversacion;
    }

    /**
     * Set usuario
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuario
     *
     * @return ChatUsuarioUsuario
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
     * Set direccion
     *
     * @param \Mapps\UsuarioBundle\Entity\User $direccion
     *
     * @return ChatUsuarioUsuario
     */
    public function setDireccion(\Mapps\UsuarioBundle\Entity\User $direccion = null)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return \Mapps\UsuarioBundle\Entity\User
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
}
