<?php
namespace Search\Repository;
use Doctrine\ORM\EntityRepository;
use Import\Entity\Ulice;
use Import\Entity\Miejscowosci;
use Import\Entity\Gminy;
use Import\Entity\Powiaty;
use Import\Entity\Wojewodztwa;
use Doctrine\ORM\Query\ResultSetMapping;


class WojewodztwaRepository extends EntityRepository
{


    //Zapytania do DB na potrzeby API
    public function findUlica($ulNazwaGlowna)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Ulice::class, 'p')
            ->where('p.ulNazwaGlowna LIKE ?1')
            ->setParameter('1', '%'.$ulNazwaGlowna.'%');
        return $queryBuilder->getQuery();
    }

    public function findMiejscowosc($miejscNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Miejscowosci::class, 'p')
            ->where('p.miejscNazwa LIKE ?1')
            ->setParameter('1', '%'.$miejscNazwa.'%');
        return $queryBuilder->getQuery();
    }




    public function findGmina($gmNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Gminy::class, 'p')
            ->where('p.gmNazwa LIKE ?1')
            ->setParameter('1', '%'.$gmNazwa.'%');
        return $queryBuilder->getQuery();
    }

    public function findPowiat($powNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Powiaty::class, 'p')
            ->where('p.powNazwa LIKE ?1')
            ->setParameter('1', '%'.$powNazwa.'%');
        return $queryBuilder->getQuery();
    }

    public function findWojewodztwo($wojNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Wojewodztwa::class, 'p')
            ->where('p.wojNazwa LIKE ?1')
            ->setParameter('1', '%'.$wojNazwa.'%');
        return $queryBuilder->getQuery();
    }



    public function findPowiatuNaPodstawieNazwyWojewodztwa($powNazwa,$wojNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p.powNazwa')
            ->from(Powiaty::class, 'p')
            ->from(Wojewodztwa::class,'w')
            ->where('w.wojIdTeryt=p.wojIdTeryt')
            ->andwhere('w.wojNazwa LIKE ?2')
            ->andwhere('p.powNazwa LIKE ?1')
            ->setParameter('1', '%'.$powNazwa.'%')
            ->setParameter('2', '%'.$wojNazwa.'%');
        return $queryBuilder->getQuery();
    }

    public function findGminyNaPodstawiePowiatu($powNazwa,$gmNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('g.gmNazwa')
            ->from(Gminy::class,'g')
            ->from(Powiaty::class, 'p')
            ->where('p.powIdTeryt=g.powIdTeryt')
            ->andwhere('p.powNazwa LIKE ?1')
            ->andwhere('g.gmNazwa LIKE ?2')
            ->setParameter('1', '%'.$powNazwa.'%')
            ->setParameter('2', '%'.$gmNazwa.'%');
        return $queryBuilder->getQuery();
    }

    public function findMiejscowosciNaPodstawieGminy($gmNazwa,$miejscNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('m.miejscNazwa')
            ->from(Gminy::class,'g')
            ->from(Miejscowosci::class,'m')
            ->where(' g.gmIdTeryt=m.gmIdTeryt')
            ->andwhere('m.miejscNazwa LIKE ?1')
            ->andwhere('g.gmNazwa LIKE ?2')
            ->setParameter('1', '%'.$miejscNazwa.'%')
            ->setParameter('2', '%'.$gmNazwa.'%');
        return $queryBuilder->getQuery();
    }


    public function findUliceNaPodstawieMiejscowosci($ulNazwa,$miejscNazwa)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u.ulNazwaGlowna')
            ->from(Ulice::class, 'u')
            ->from(Miejscowosci::class,'m')
            ->where('m.miejscIdTeryt=u.miejscIdTeryt')
            ->andwhere('m.miejscNazwa LIKE ?1')
            ->andwhere('u.ulNazwaGlowna LIKE ?2')
            ->setParameter('1', '%'.$miejscNazwa.'%')
            ->setParameter('2', '%'.$ulNazwa.'%');
        return $queryBuilder->getQuery();
    }















    public function  findUlicaFull($ulNazwaGlowna)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u.ulNazwaGlowna,m.miejscNazwa,g.gmNazwa,p.powNazwa,w.wojNazwa')
            ->from(Ulice::class, 'u')
            ->from(Miejscowosci::class,'m')
            ->from(Gminy::class,'g')
            ->from(Powiaty::class,'p')
            ->from(Wojewodztwa::class,'w')
            ->where(' m.miejscIdTeryt=u.miejscIdTeryt')
            ->andwhere(' g.gmIdTeryt=m.gmIdTeryt')
            ->andwhere(' p.powIdTeryt=g.powIdTeryt')
            ->andwhere(' w.wojIdTeryt=p.wojIdTeryt')
            ->andwhere('u.ulNazwaGlowna LIKE ?1')
            ->setParameter('1', '%'.$ulNazwaGlowna.'%');
        return $queryBuilder->getQuery();

    }


















}
