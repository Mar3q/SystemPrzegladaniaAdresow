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


// This controller is designed for managing image file uploads.
class FileController extends AbstractActionController
{

    /**
     * Constructor. Its purpose is to inject dependencies into the controller.
     */



    // The image manager.
    private $fileManager;

    private $authService;

    private $entityManager;
    // The constructor method is used for injecting the dependencies
    // into the controller.
    public function __construct($fileManager,$authService,$entityManager)
    {
        $this->fileManager = $fileManager ;
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    // This is the default "index" action of the controller. It displays the uploaded files.----------------------------
    public function indexAction()
    {
        // Get the list of already saved files.
        $files = $this->fileManager->getSavedFiles();
        $filesUnpacked = $this->fileManager->getUnpackedFiles();
        // Render the view template.
        return new ViewModel([
            'files'=>$files,
            'filesUnpacked'=>$filesUnpacked
        ]);
    }

    //--------------delete Actions--------------------------------------------------------------------------------------
    public function deleteunpackedfileAction()
    {
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager-> deleteUnpackedFile($fileName);
        // Get the list of already saved files.
        // Render the view template.
        return new ViewModel([
            'fileName' => $fileName
        ]);
    }

    public function deleteunpackedfilesdirAction()
    {
        $this->fileManager->deleteUnpackedFilesDir();
        return new ViewModel([
        ]);
    }

    public function deletezipfileAction()
    {
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager-> deleteZipFile($fileName);
        // Get the list of already saved files.
        // Render the view template.
        return new ViewModel([
            'fileName' => $fileName
        ]);
    }

    public function deletezipfilesdirAction()
    {
        $this->fileManager->deleteZipFilesDir();
        return new ViewModel([
        ]);
    }

    //-------------------------------  This Action allows to upload a single file.--------------------------------------
    public function uploadAction()
    {
        // Create the form model.
        $form = new FileForm();

        // Check if user has submitted the form.
        if($this->getRequest()->isPost()) {

            // Make certain to merge the files info!
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            // Pass data to form.
            $form->setData($data);

            // Validate form.
            if($form->isValid()) {

                // Move uploaded file to its destination directory.
                $data = $form->getData();

                // Redirect the user to "Image Gallery" page.
                return $this->redirect()->toRoute('files');
            }
        }

        // Render the page.
        return new ViewModel([
            'form' => $form
        ]);
    }


    //-------------------------------  This Action allows to unpack a zip file.-----------------------------------------
    public function unpackAction()
    {
        $fileName = $this->params()->fromQuery('name');
        $this->fileManager-> unpackZipFile($fileName);

        return new ViewModel([
            'fileName' => $fileName
        ]);
    }

    //-------------------------------  This Action show xml file content.-----------------------------------------------
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

    //-------------------------------  This allow  to import xml file to database.--------------------------------------
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


    //-------------------------------  This allow to import zip file to database.---------------------------------------
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



















    // This is the 'file' action that is invoked when a user wants to
    // open the image file in a web browser or generate a thumbnail.
    public function fileAction()
    {
        // Get the file name from GET variable.
        $fileName = $this->params()->fromQuery('name', '');

        // Get path to image file.
        $fileName = $this->fileManager->getImagePathByName($fileName);

        // Get image file info (size and MIME type).
        $fileInfo = $this->fileManager->getImageFileInfo($fileName);

        if ($fileInfo===false) {
            // Set 404 Not Found status code
            $this->getResponse()->setStatusCode(404);
            return;
        }


        // Write HTTP headers.
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: " . $fileInfo['type']);
        $headers->addHeaderLine("Content-length: " . $fileInfo['size']);

        // Write file content.
        $fileContent = $this->fileManager->getImageFileContent($fileName);
        if($fileContent!==false) {
            $response->setContent($fileContent);
        } else {
            // Set 500 Server Error status code.
            $this->getResponse()->setStatusCode(500);
            return;
        }


        // Return Response to avoid default view rendering.
        return $this->getResponse();
    }


}