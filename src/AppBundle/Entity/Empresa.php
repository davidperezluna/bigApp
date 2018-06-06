<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Empresa
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
     * @var int
     * @ORM\Column(name="visitas", type="bigint")
     */
    private $visitas = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=255)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=255)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="fotoLogo", type="string", length=255)
     */
    private $fotoLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="fotoPortada", type="string", length=255)
     */
    private $fotoPortada;

    /**
     * @var string
     *
     * @ORM\Column(name="fotoPortadaCov", type="string", length=255)
     */
    private $fotoPortadaCov;

    /**
     * @var string
     *
     * @ORM\Column(name="paginaWeb", type="string", length=255)
     */
    private $paginaWeb;

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
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=255)
     */
    private $lng;
    
    /**
     * @var string
     *
     * @ORM\Column(name="colorPrimario", type="string", length=255)
     */
    private $colorPrimario;
    /**
     * @var string
     *
     * @ORM\Column(name="colorSecundario", type="string", length=255)
     */
    private $colorSecundario;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="date" , nullable = true)
     */
    private $updatedAt;
    /**
     * @var string
     *
     * @ORM\Column(name="posicionamiento", type="string", length=255)
     */
    private $posicionamiento = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Mapps\MappsUsuarioBundle\Entity\User", inversedBy="empresas")
     */
    protected $usuario;
    
    /**
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="empresas")
     */
    protected $municipio;

    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="empresa")
     */
    private $productos;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaSector", mappedBy="empresa")
     */
    private $empresasSectores;
    /**
     * @ORM\OneToMany(targetEntity="ImagenEmpresa", mappedBy="empresa")
     */
    private $imagenes;
    /**
     * @ORM\OneToMany(targetEntity="PlanEmpresa", mappedBy="empresa")
     */
    private $planesEmpresa;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaRecorrido360", mappedBy="empresa")
     */
    private $recorridos;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaRedes", mappedBy="empresa")
     */
    private $redes;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaSubCategoria", mappedBy="empresa")
     */
    private $subCategorias;

    public function __construct() {
        $this->imagenes = new ArrayCollection();
        $this->productos = new ArrayCollection();
        $this->empresasSectores = new ArrayCollection();
        $this->planesEmpresa = new ArrayCollection();
        $this->recorridos = new ArrayCollection();
        $this->redes = new ArrayCollection();
        $this->subCategorias = new ArrayCollection();
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
     * @return Empresa
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
     * Set correo
     *
     * @param string $correo
     * @return Empresa
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Empresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Empresa
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Empresa
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set fotoLogo
     *
     * @param string $fotoLogo
     * @return Empresa
     */
    public function setFotoLogo($fotoLogo)
    {
        $this->fotoLogo = $fotoLogo;

        return $this;
    }

    /**
     * Get fotoLogo
     *
     * @return string
     */
    public function getFotoLogo()
    {
        return $this->fotoLogo;
    }

    /**
     * Set fotoPortada
     *
     * @param string $fotoPortada
     * @return Empresa
     */
    public function setFotoPortada($fotoPortada)
    {
        $this->fotoPortada = $fotoPortada;

        return $this;
    }

    /**
     * Get fotoPortada
     *
     * @return string
     */
    public function getFotoPortada()
    {
        return $this->fotoPortada;
    }

    /**
     * Set paginaWeb
     *
     * @param string $paginaWeb
     * @return Empresa
     */
    public function setPaginaWeb($paginaWeb)
    {
        $this->paginaWeb = $paginaWeb;

        return $this;
    }

    /**
     * Get paginaWeb
     *
     * @return string
     */
    public function getPaginaWeb()
    {
        return $this->paginaWeb;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Empresa
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
    * Gets triggered only on insert

    * @ORM\PrePersist
    */
   public function onPrePersist()
   {
       $this->createdAt = new \DateTime("now");
   }

   /**
    * Gets triggered every time on update

    * @ORM\PreUpdate
    */
   public function onPreUpdate()
   {
       $this->updatedAt = new \DateTime("now");
   }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Empresa
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

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Empresa
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Empresa
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Empresa
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     * @return Empresa
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


    /**
     * Add productos
     *
     * @param \AppBundle\Entity\Producto $productos
     * @return Empresa
     */
    public function addProducto(\AppBundle\Entity\Producto $productos)
    {
        $this->productos[] = $productos;

        return $this;
    }

    /**
     * Remove productos
     *
     * @param \AppBundle\Entity\Producto $productos
     */
    public function removeProducto(\AppBundle\Entity\Producto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Add empresasSectores
     *
     * @param \AppBundle\Entity\EmpresaSector $empresasSectores
     * @return Empresa
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


    /**
     * Set colorPrimario
     *
     * @param string $colorPrimario
     * @return Empresa
     */
    public function setColorPrimario($colorPrimario)
    {
        $this->colorPrimario = $colorPrimario;

        return $this;
    }

    /**
     * Get colorPrimario
     *
     * @return string
     */
    public function getColorPrimario()
    {
        return $this->colorPrimario;
    }

    /**
     * Set colorSecundario
     *
     * @param string $colorSecundario
     * @return Empresa
     */
    public function setColorSecundario($colorSecundario)
    {
        $this->colorSecundario = $colorSecundario;

        return $this;
    }

    /**
     * Get colorSecundario
     *
     * @return string
     */
    public function getColorSecundario()
    {
        return $this->colorSecundario;
    }

    /**
     * Add imagenes
     *
     * @param \AppBundle\Entity\ImagenEmpresa $imagenes
     * @return Empresa
     */
    public function addImagene(\AppBundle\Entity\ImagenEmpresa $imagenes)
    {
        $this->imagenes[] = $imagenes;

        return $this;
    }

    /**
     * Remove imagenes
     *
     * @param \AppBundle\Entity\ImagenEmpresa $imagenes
     */
    public function removeImagene(\AppBundle\Entity\ImagenEmpresa $imagenes)
    {
        $this->imagenes->removeElement($imagenes);
    }

    /**
     * Get imagenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImagenes()
    {
        return $this->imagenes;
    }

    /**
     * Add planesEmpresa
     *
     * @param \AppBundle\Entity\PlanEmpresa $planesEmpresa
     * @return Empresa
     */
    public function addPlanesEmpresa(\AppBundle\Entity\PlanEmpresa $planesEmpresa)
    {
        $this->planesEmpresa[] = $planesEmpresa;

        return $this;
    }

    /**
     * Remove planesEmpresa
     *
     * @param \AppBundle\Entity\PlanEmpresa $planesEmpresa
     */
    public function removePlanesEmpresa(\AppBundle\Entity\PlanEmpresa $planesEmpresa)
    {
        $this->planesEmpresa->removeElement($planesEmpresa);
    }

    /**
     * Get planesEmpresa
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanesEmpresa()
    {
        return $this->planesEmpresa;
    }

    /**
     * Add recorridos
     *
     * @param \AppBundle\Entity\EmpresaRecorrido360 $recorridos
     * @return Empresa
     */
    public function addRecorrido(\AppBundle\Entity\EmpresaRecorrido360 $recorridos)
    {
        $this->recorridos[] = $recorridos;

        return $this;
    }

    /**
     * Remove recorridos
     *
     * @param \AppBundle\Entity\EmpresaRecorrido360 $recorridos
     */
    public function removeRecorrido(\AppBundle\Entity\EmpresaRecorrido360 $recorridos)
    {
        $this->recorridos->removeElement($recorridos);
    }

    /**
     * Get recorridos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecorridos()
    {
        return $this->recorridos;
    }

    /**
     * Set posicionamiento
     *
     * @param string $posicionamiento
     * @return Empresa
     */
    public function setPosicionamiento($posicionamiento)
    {
        $this->posicionamiento = $posicionamiento;

        return $this;
    }

    /**
     * Get posicionamiento
     *
     * @return string
     */
    public function getPosicionamiento()
    {
        return $this->posicionamiento;
    }

    /**
     * Set visitas
     *
     * @param integer $visitas
     * @return Empresa
     */
    public function setVisitas($visitas)
    {
        $this->visitas = $visitas;

        return $this;
    }

    /**
     * Get visitas
     *
     * @return integer
     */
    public function getVisitas()
    {
        return $this->visitas;
    }

    /**
     * Add redes
     *
     * @param \AppBundle\Entity\EmpresaRedes $redes
     * @return Empresa
     */
    public function addRede(\AppBundle\Entity\EmpresaRedes $redes)
    {
        $this->redes[] = $redes;

        return $this;
    }

    /**
     * Remove redes
     *
     * @param \AppBundle\Entity\EmpresaRedes $redes
     */
    public function removeRede(\AppBundle\Entity\EmpresaRedes $redes)
    {
        $this->redes->removeElement($redes);
    }

    /**
     * Get redes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRedes()
    {
        return $this->redes;
    }

    /**
     * Add subCategorias
     *
     * @param \AppBundle\Entity\EmpresaSubCategoria $subCategorias
     * @return Empresa
     */
    public function addSubCategoria(\AppBundle\Entity\EmpresaSubCategoria $subCategorias)
    {
        $this->subCategorias[] = $subCategorias;

        return $this;
    }

    /**
     * Remove subCategorias
     *
     * @param \AppBundle\Entity\EmpresaSubCategoria $subCategorias
     */
    public function removeSubCategoria(\AppBundle\Entity\EmpresaSubCategoria $subCategorias)
    {
        $this->subCategorias->removeElement($subCategorias);
    }

    /**
     * Get subCategorias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategorias()
    {
        return $this->subCategorias;
    }

    /**
     * Set fotoPortadaCov
     *
     * @param string $fotoPortadaCov
     * @return Empresa
     */
    public function setFotoPortadaCov($fotoPortadaCov)
    {
        $this->fotoPortadaCov = $fotoPortadaCov;

        return $this;
    }

    /**
     * Get fotoPortadaCov
     *
     * @return string 
     */
    public function getFotoPortadaCov()
    {
        return $this->fotoPortadaCov;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Empresa
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     * @return Empresa
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set usuario
     *
     * @param \Mapps\UsuarioBundle\Entity\User $usuario
     *
     * @return Empresa
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
}
