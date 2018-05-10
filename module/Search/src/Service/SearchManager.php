<?php
/**
 * A service model class encapsulating the functionality for image management.
 */

namespace Search\Service;
use Doctrine\ORM\EntityRepository;
use Import\Entity\Gminy;
use Import\Entity\Miejscowosci;
use Import\Entity\Powiaty;
use Import\Entity\Ulice;
use ZipArchive;
use SimpleXMLElement;
use Import\Entity\Wojewodztwa;




class SearchManager extends EntityRepository
{

    private $entityManager;
    private $authService;
    public function __construct($entityManager,$authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }



    public function findUlice()
    {
        $ulice2 = [];
       $ulice = $this->entityManager->getRepository(Ulice::class)->findUlica();


        foreach ($ulice as $ulica) {
            $ulice2[] = $ulica->getulNazwaGlowna()->getResult();
        }


        return $ulice2;

    }

    public function wyswietl()
    {
        $a = "funckja wyswietl";
        return $a;
    }






}












