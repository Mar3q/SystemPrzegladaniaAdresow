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


class SearchController extends AbstractActionController
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

    //Paginator
        /*
        $page = $this->params()->fromQuery('page', 1);
        $wojewodztwa2 = $this->entityManager->getRepository(Powiaty::class)->findPowiat();
        $adapter = new DoctrineAdapter(new ORMPaginator($wojewodztwa2, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        */


        // Przechwytuje wszystkie dane z bazy (Testowo dla małej ilości danych w bazie)
        $wojewodztwa  = $this->entityManager->getRepository(Wojewodztwa::class)->findBy([], ['wojNazwa'=>'ASC']);
        $powiaty  = $this->entityManager->getRepository(Powiaty::class)->findBy([], ['powNazwa'=>'ASC']);
        $gminy = $this->entityManager->getRepository(Gminy::class)->findBy([], ['gmNazwa'=>'ASC']);
        $miejscowosci  = $this->entityManager->getRepository(Miejscowosci::class)->findBy([], ['miejscIdTeryt'=>'ASC']);
        $ulice  = $this->entityManager->getRepository(Ulice::class)->findBy([], ['ulNazwaGlowna'=>'ASC']);

        return new ViewModel([
            'wojewodztwa' => $wojewodztwa,
            'powiaty' => $powiaty,
            'gminy' => $gminy,
            'miejscowosci' => $miejscowosci,
            'ulice' => $ulice,
            'searchManager' => $this->searchManager
        ]);


    }


    //Do poprawy
    public function findAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $ulNazwaGlowna = $this->params()->fromPost();
        $ulNazwaGlowna = implode("",$ulNazwaGlowna);

        $ulice = $this->entityManager->getRepository(Ulice::class)->findUlica($ulNazwaGlowna);

        return new ViewModel([
        'ulice' => $ulice,
            ]);
    }


}
