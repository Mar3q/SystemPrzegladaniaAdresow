<?php
namespace Search\Controller;

use Import\Entity\Gminy;
use Import\Entity\Miejscowosci;
use Import\Entity\Powiaty;
use Import\Entity\Ulice;
use Import\Entity\Wojewodztwa;
use Import\Entity\Post;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\Router;
use Zend\Barcode;
use Zend\Router\RouteMatch;
use Zend\Dom\Query;
use RestApi\Controller\ApiController;


//Ten kontroler reprezentuje API
class SearchController extends ApiController
{

    private $searchManager;
    private $authService;
    private $entityManager;


    public function __construct($searchManager,$authService,$entityManager)
    {
        $this->searchManager = $searchManager ;
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    //Do poprawy
    public function indexAction()
    {


    }


    //Do poprawy
    public function findAction()
    {


    }

    public function wojewodztwaAction()
    {
        $wojNazwa = $this->params()->fromQuery('nazwaWojewodztwa');
        $dlugoscNazwy = strlen($wojNazwa);
        $error = "Nie znaleziono wojejewodztwa o podanej nazwie w bazie danych";
        
        
        if(empty($wojNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaWojewodztwa';
            return $this->createResponse();
        }
        
        if($dlugoscNazwy < 1 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa wojewodztwa musi zawierac przynajmniej 1 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 1)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;
            $wojewodztwa = $this->entityManager->getRepository(Wojewodztwa::class)->findWojewodztwo($wojNazwa)->getResult();
            if($wojewodztwa != null) {
                $this->apiResponse['wojewodztwa'] = $wojewodztwa;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }

    public function powiatuAction()
    {
        $powNazwa = $this->params()->fromQuery('nazwaPowiatu');
        $dlugoscNazwy = strlen($powNazwa);
        $error = "Nie znaleziono powiatu o podanej nazwie w bazie danych";

        if(empty($powNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaPowiatu';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 3 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 3)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;
            $powiaty = $this->entityManager->getRepository(Powiaty::class)->findPowiat($powNazwa)->getResult();

            if($powiaty != null) {
                $this->apiResponse['powiaty'] = $powiaty;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }

    public function gminyAction()
    {
        $gmNazwa = $this->params()->fromQuery('nazwaGminy');
        $dlugoscNazwy = strlen($gmNazwa);
        $error = "Nie znaleziono gminy o podanej nazwie w bazie danych";

        if(empty($gmNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaGminy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 3 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 3)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;
            $gminy = $this->entityManager->getRepository(Gminy::class)->findGmina($gmNazwa)->getResult();

            if($gminy != null) {
                $this->apiResponse['gminy'] = $gminy;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }

    public function miejscowosciAction()
    {
        // your action logic

        $miejscNazwa = $this->params()->fromQuery('nazwaMiejscowosci');
        $dlugoscNazwy = strlen($miejscNazwa);
        $error = "Nie znaleziono miejscowosci o podanej nazwie w bazie danych";

        if(empty($miejscNazwa))
        {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaMiejscowosci';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 3 )
        {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 3)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;
            $ulice = $this->entityManager->getRepository(Miejscowosci::class)->findMiejscowosc($miejscNazwa)->getResult();

            if($ulice != null) {
                $this->apiResponse['miejscowosci'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }

    public function ulicyAction()
    {


        $ulNazwa = $this->params()->fromQuery('nazwaUlicy');
        $dlugoscNazwy = strlen($ulNazwa);
        $error = "Nie znaleziono ulicy o podanej nazwie w bazie danych";

        if(empty($ulNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaUlicy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 3 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 3)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;
            $ulice = $this->entityManager->getRepository(Ulice::class)->findUlica($ulNazwa)->getResult();

            if($ulice != null) {
                $this->apiResponse['ulice'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }

    public function ulicywzglednieAction()
    {


        $ulNazwa = $this->params()->fromQuery('nazwaUlicy');
        $dlugoscNazwy = strlen($ulNazwa);
        $error = "Nie znaleziono ulicy o podanej nazwie w bazie danych";

        if(empty($ulNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaUlicy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 3 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 3)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;

            $ulice = $this->entityManager->getRepository(Ulice::class)->findUlicaFull($ulNazwa)->getResult();


            if($ulice != null) {
                $this->apiResponse['ulice'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }


    public function powiatunapodstawienazwywojewodztwaAction()
    {


        $powNazwa = $this->params()->fromQuery('powNazwa');
        $wojNazwa = $this->params()->fromQuery('wojNazwa');

        $dlugoscNazwy = strlen($powNazwa);

        $error = "Nie znaleziono powiatu o podanej nazwie w bazie danych";

        if(empty($powNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaUlicy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 2 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 2)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;


            $ulice = $this->entityManager->getRepository(Powiaty::class)->findPowiatuNaPodstawieNazwyWojewodztwa($powNazwa,$wojNazwa)->getResult();

            if($ulice != null) {
                $this->apiResponse['powiaty'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }


    public function gminynapodstawiepowiatuAction()
    {


        $powNazwa = $this->params()->fromQuery('powNazwa');
        $wojNazwa = $this->params()->fromQuery('gmNazwa');

        $dlugoscNazwy = strlen($powNazwa);

        $error = "Nie znaleziono gminy o podanej nazwie w bazie danych";

        if(empty($powNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaUlicy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 2 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 2)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;


            $ulice = $this->entityManager->getRepository(Gminy::class)->findGminyNaPodstawiePowiatu($powNazwa,$wojNazwa)->getResult();

            if($ulice != null) {
                $this->apiResponse['gminy'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }

    public function miejscowoscinapodstawiegminyAction()
    {


        $powNazwa = $this->params()->fromQuery('miejscNazwa');
        $wojNazwa = $this->params()->fromQuery('gmNazwa');

        $dlugoscNazwy = strlen($powNazwa);

        $error = "Nie znaleziono gminy o podanej nazwie w bazie danych";

        if(empty($powNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaUlicy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 2 ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 2)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;


            $ulice = $this->entityManager->getRepository(Gminy::class)->findMiejscowosciNaPodstawieGminy($wojNazwa,$powNazwa)->getResult();

            if($ulice != null) {
                $this->apiResponse['miejscowosci'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }


    public function ulicynapodstawiemiejscowosciAction()
    {


        $powNazwa = $this->params()->fromQuery('miejscNazwa');
        $wojNazwa = $this->params()->fromQuery('ulNazwaGlowna');

        $dlugoscNazwy = strlen($powNazwa);


        $error = "Nie znaleziono gminy o podanej nazwie w bazie danych";

        if(empty($powNazwa)) {
            $this->apiResponse['Informacja'] = 'Wprowdzono błędną nazwe parametru, użyj parametru: nazwaUlicy';
            return $this->createResponse();
        }

        if($dlugoscNazwy < 2  ) {
            $this->apiResponse['Informacja'] = 'Wprowdzono za mało znaków, nazwa musi zawierac przynajmniej 3 znaki ';
            return $this->createResponse();
        }

        if($dlugoscNazwy >= 2)
        {
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 200;


            $ulice = $this->entityManager->getRepository(Gminy::class)->findUliceNaPodstawieMiejscowosci($wojNazwa,$powNazwa)->getResult();

            if($ulice != null) {
                $this->apiResponse['ulice'] = $ulice;
                return $this->createResponse();
            }
            else {
                $this->apiResponse['Informacja'] = $error;
                return $this->createResponse();
            }

        }
    }
}
