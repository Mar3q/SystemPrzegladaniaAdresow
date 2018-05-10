<?php
namespace Search\Repository;
use Doctrine\ORM\EntityRepository;
use Import\Entity\Ulice;
use Import\Entity\Miejscowosci;
use Import\Entity\Gminy;
use Import\Entity\Powiaty;
use Import\Entity\Wojewodztwa;



class WojewodztwaRepository extends EntityRepository
{

    //Zapytania do bazy danych

    public function findUlica($ulNazwaGlowna)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Ulice::class, 'p')
            ->where('p.ulNazwaGlowna = ?1')
            ->setParameter('1', $ulNazwaGlowna);
        return $queryBuilder->getQuery();
    }

    public function findMiejscowosc($miejscNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Miejscowosci::class, 'p')
            ->where('p.miejscNazwa = ?1')
            ->setParameter('1', $miejscNazwa);
        return $queryBuilder->getQuery();
    }

    public function findGmina($gmIdTeryt)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Gminy::class, 'p')
            ->where('p.gmIdTeryt = ?1')
            ->setParameter('1', $gmIdTeryt);
        return $queryBuilder->getQuery();
    }

    public function findPowiat($powIdTeryt)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Powiaty::class, 'p')
            ->where('p.powIdTeryt = ?1')
            ->setParameter('1', $powIdTeryt);
        return $queryBuilder->getQuery();
    }

    public function findWojewodztwa($wojIdTeryt)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('p')
            ->from(Wojewodztwa::class, 'p')
            ->orderBy('p.wojNazwa', 'ASC');
        return $queryBuilder->getQuery();
    }










}
