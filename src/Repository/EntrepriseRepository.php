<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }


    public function findByKeyword($keyword): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            '
            SELECT e
            FROM App\Entity\Entreprise e
            WHERE e.nom_ent LIKE :keyword 
             OR e.responsable LIKE :keyword 
             OR e.email LIKE :keyword 
             OR e.num_tel LIKE :keyword
            '
        )->setParameter('keyword', '%' . $keyword . '%');

        return $query->getResult();
    }
 
}
