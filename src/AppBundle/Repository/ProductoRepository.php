<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductoRepository extends EntityRepository
{
  public function findProductosPorNombre($nombre,$categoriaId,$municipioId)
  {

      if ($nombre!='') {
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p  FROM AppBundle:Producto p
                WHERE p.tags  LIKE :nombre
                ORDER BY p.valor asc
                '
            )
            ->setParameter('nombre', '%'.$nombre.'%');
        }
        if ($categoriaId!='') {
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p  FROM AppBundle:Producto p
                JOIN p.empresa e
                WHERE p.subCategoria =:categoria
                ORDER BY p.valor asc
                '
            )
            ->setParameter('categoria', $categoriaId);
        }
        if ($municipioId!='') {
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p  FROM AppBundle:Producto p
                JOIN p.empresa e
                WHERE e.municipio = :municipio
                ORDER BY p.valor asc
                '
            )
            ->setParameter('municipio', $municipioId);
        }
        if (($nombre!='') && ($municipioId !='')) {
            $query = $this->getEntityManager()
            ->createQuery(
              'SELECT p  FROM AppBundle:Producto p
              JOIN p.empresa e
              WHERE p.tags  LIKE :nombre
              AND e.municipio = :municipio
              ORDER BY p.valor asc
              '
          )
          ->setParameter('nombre', '%'.$nombre.'%')
          ->setParameter('municipio', $municipioId);
        }
        if (($nombre!='') && ($categoriaId !='')) {
            
            $query = $this->getEntityManager()
          ->createQuery(
              'SELECT p  FROM AppBundle:Producto p
              JOIN p.empresa e
              WHERE p.tags  LIKE :nombre
              AND p.subCategoria =:categoria
              ORDER BY p.valor asc
              '
          )
          ->setParameter('nombre', '%'.$nombre.'%')
          ->setParameter('categoria', $categoriaId);
        }
        if (($municipioId !='') && ($categoriaId !='')) {
            
            $query = $this->getEntityManager()
          ->createQuery(
              'SELECT p  FROM AppBundle:Producto p
              JOIN p.empresa e
              WHERE e.municipio = :municipio
              AND p.subCategoria =:categoria
              ORDER BY p.valor asc
              '
          )
          ->setParameter('municipio', $municipioId)
          ->setParameter('categoria', $categoriaId);
        }
        if (($municipioId !='') && ($categoriaId !='') && ($nombre!='')) {
            
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p  FROM AppBundle:Producto p
                JOIN p.empresa e
                WHERE p.tags  LIKE :nombre
                AND e.municipio = :municipio
                AND p.subCategoria =:categoria 
                ORDER BY p.valor asc
                '
            )
            ->setParameter('nombre', '%'.$nombre.'%')
            ->setParameter('municipio', $municipioId)
            ->setParameter('categoria', $categoriaId);
        }
        if (($municipioId =='') && ($categoriaId =='') && ($nombre=='')) {
            
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p  FROM AppBundle:Producto p
                ORDER BY p.valor asc
                '
            );
        }
        $productos = $query->getResult();
        return $productos;

  }

  public function findProductosPorNombreYEmpresa($nombre,$empresa)
  {
      $idEmpresa = $empresa->getId();
      $query = $this->getEntityManager()
          ->createQuery(
              'SELECT p  FROM AppBundle:Producto p
              JOIN p.empresa e
              WHERE p.tags  LIKE :nombre
              AND e.id = :empresa'
          )
          ->setParameter('nombre', '%'.$nombre.'%')
          ->setParameter('empresa', $idEmpresa);

          $productos = $query->getResult();
          return $productos;
  }

  public function findProductosPorNombreCategoriaMunicipio($nombre,$municipioId,$categoriaId)
  {
      
      $query = $this->getEntityManager()
          ->createQuery(
              'SELECT p  FROM AppBundle:Producto p
              JOIN p.empresa e
              WHERE p.tags  LIKE :nombre
              AND e.municipio = :municipio
              AND p.subCategoria =:categoria'
          )
          ->setParameter('nombre', '%'.$nombre.'%')
          ->setParameter('municipio', $municipioId)
          ->setParameter('categoria', $categoriaId);
          ;

          $productos = $query->getResult();
          return $productos;
  }
}
