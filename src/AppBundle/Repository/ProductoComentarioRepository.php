<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductoComentarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductoComentarioRepository extends EntityRepository
{
  public function findComentariosProductosNoVistosPorUsuario($usuario)
  {
      $query = $this->getEntityManager()
          ->createQuery(
              'SELECT pc  FROM AppBundle:ProductoComentario pc
              JOIN pc.producto p
              JOIN p.empresa e
              JOIN e.usuario u
              WHERE u.id  = :usuario
              AND pc.visto = 0
              ORDER BY pc.created DESC
              '
          )
          ->setParameter('usuario', $usuario->getId());
          $comentarios = $query->getResult();
          return $comentarios;
  }
}
