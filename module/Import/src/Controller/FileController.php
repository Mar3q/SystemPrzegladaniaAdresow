<?php
namespace Import\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Import\Form\FileForm;
use Zend\Router;
use Zend\Barcode;
use Zend\Router\RouteMatch;
use Zend\Dom\Query;
use SimpleXMLElement;
use User\Service\UserManger;



class FileController extends AbstractActionController
{


    private $fileManager;
    private $authService;
    private $entityManager;

    public function __construct($fileManager,$authService,$entityManager){
        $this->fileManager = $fileManager ;
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    // Zwraca listę plików zip, oraz rozpakowanych plików.
    public function indexAction(){

        $files = $this->fileManager->getSavedFiles();
        $filesUnpacked = $this->fileManager->getUnpackedFiles();

        return new ViewModel([
            'files'=>$files,
            'filesUnpacked'=>$filesUnpacked
        ]);
    }

    //Usuwanie plików i katalogów.
    public function deleteunpackedfileAction(){
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager-> deleteUnpackedFile($fileName);
        // Get the list of already saved files.
        // Render the view template.
        return new ViewModel([
            'fileName' => $fileName
        ]);
    }
    public function deletezipfileAction(){
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager-> deleteZipFile($fileName);
        // Get the list of already saved files.
        // Render the view template.
        return new ViewModel([
            'fileName' => $fileName
        ]);
    }
    public function deleteunpackedfilesdirAction(){
        $this->fileManager->deleteUnpackedFilesDir();
        return new ViewModel([
        ]);
    }
    public function deletezipfilesdirAction(){
        $this->fileManager->deleteZipFilesDir();
        return new ViewModel([
        ]);
    }

    //Wysyłanie plików na server.
    public function uploadAction()
    {

        $form = new FileForm();
        if($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);

            if($form->isValid()) {
                $data = $form->getData();
                return $this->redirect()->toRoute('files');
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }

    //Rozpakowanie pliku.
    public function unpackAction()
    {
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager-> unpackZipFile($fileName);

        return new ViewModel([
            'fileName' => $fileName
        ]);
    }

    //Zwraca podstawowe informacje pliku xml.
    public function readxmlAction()
    {
        $blad = "Ups, wystąpił problem przy odczytu pliku.";
        $fileName = $this->params()->fromQuery('name');
        $adres = $this->fileManager->converXmlToArray($fileName);

        if(empty($adres)) {
            return new ViewModel([
                'blad' => $blad,
                'fileName' => $fileName
            ]);
        }
        else
        {
            return new ViewModel([
                'adres' => $adres,
                'fileName' => $fileName
            ]);
        }
    }

    //Wrzucanie pojedyńczego pliku xml do bazy danych.
    public function importxmlAction()
    {
        $user = $this->authService->getIdentity();
        $blad = "Ups, wystąpił problem z plikiem.";

        $fileName = $this->params()->fromQuery('name');
        $this->fileManager->importXml($fileName);
        $adres = 'xd';

        if(empty($adres)) {
            return new ViewModel([
                'blad' => $blad,
                'fileName' => $fileName
            ]);
        }


        else {
            return new ViewModel([
                'fileName' => $fileName,
                'user' => $user

            ]);
        }
    }

    //Wrzucanie paczki zip do bazy danych.
    public function importzipAction()
    {
        $user = $this->authService->getIdentity();
        $blad = "Ups, wystąpił problem z plikiem.";
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager->importZip($fileName);


        $adres = 'xd';
        if(empty($adres)) {
            return new ViewModel([
                'blad' => $blad,
                'fileName' => $fileName
            ]);
        }
        else {
            return new ViewModel([
                'fileName' => $fileName,
                'user' => $user

            ]);
        }
    }

}