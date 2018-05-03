<?php
/**
 * A service model class encapsulating the functionality for image management.
 */

namespace Import\Service;
use Import\Entity\Gminy;
use Import\Entity\Miejscowosci;
use Import\Entity\Powiaty;
use Import\Entity\Ulice;
use ZipArchive;
use SimpleXMLElement;
use Import\Entity\Wojewodztwa;



class FileManager
{


    private $entityManager;
    private $authService;
    public function __construct($entityManager,$authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    //--------------------------The directory where we save files--------------------------------------------------------
    private $zipFilesDir = './data/upload/';
    private $unpackedFilesDir = './data/unziped/';
    private $temporaryFilesDir = './data/temp/';


    //--------------------------Primary file functions------------------------------------------------------------------
    public function getZipFilesDir()
    {
        return $this->zipFilesDir;
    }

    public function getUnpackedFilesDir()
    {
        return $this->unpackedFilesDir;
    }

    public function getTemporaryFilesDir()
    {
        return $this->temporaryFilesDir;
    }

    public function getZipFilePathByName($fileName)
    {
        // Take some precautions to make file name secure
        $fileName = str_replace("/", "", $fileName);  // Remove slashes
        $fileName = str_replace("\\", "", $fileName); // Remove back-slashes
        // Return concatenated directory name and file name.
        return $this->zipFilesDir . $fileName;
    }

    public function getUnpackedFilePathByName($fileName)
    {
        $fileName = str_replace("/", "", $fileName);  // Remove slashes
        $fileName = str_replace("\\", "", $fileName); // Remove back-slashes
        return $this->unpackedFilesDir . $fileName;
    }

    public function getTemporaryFilePathByName($fileName)
    {
        $fileName = str_replace("/", "", $fileName);  // Remove slashes
        $fileName = str_replace("\\", "", $fileName); // Remove back-slashes
        // Return concatenated directory name and file name.
        return $this->temporaryFilesDir . $fileName;
    }

    public function getSavedFiles()
    {
        if (!is_dir($this->zipFilesDir)) {
            if (!mkdir($this->zipFilesDir)) {
                throw new \Exception('Could not create directory for uploads: ' . error_get_last());
            }
        }
        // Scan the directory and create the list of uploaded files.
        $files = array();
        $handle = opendir($this->zipFilesDir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '.' || $entry == '..')
                continue; // Skip current dir and parent dir.
            $files[] = $entry;
        }
        // Return the list of uploaded files.
        return $files;
    }

    public function getUnpackedFiles()
    {
        if (!is_dir($this->unpackedFilesDir)) {
            if (!mkdir($this->unpackedFilesDir)) {
                throw new \Exception('Could not create directory for uploads: ' . error_get_last());
            }
        }
        $files = array();
        $handle = opendir($this->unpackedFilesDir);
        while (false !== ($entry = readdir($handle))) {

            if ($entry == '.' || $entry == '..')
                continue;
            $files[] = $entry;
        }
        return $files;
    }

    public function getTemporaryFiles()
    {
        if (!is_dir($this->temporaryFilesDir)) {
            if (!mkdir($this->temporaryFilesDir)) {
                throw new \Exception('Could not create directory for uploads: ' . error_get_last());
            }
        }
        $files = array();
        $handle = opendir($this->temporaryFilesDir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '.' || $entry == '..')
                continue;
            $files[] = $entry;
        }
        return $files;
    }

    public function getFileInfo($filePath)
    {
        // Try to open file        
        if (!is_readable($filePath)) {
            return false;
        }

        // Get file size in bytes.
        $fileSize = filesize($filePath);

        // Get MIME type of the file.
        $finfo = finfo_open(FILEINFO_MIME);
        $mimeType = finfo_file($finfo, $filePath);
        if ($mimeType === false)
            $mimeType = 'import/octet-stream';
        return [
            'size' => $fileSize,
            'type' => $mimeType
        ];
    }

    public function getFileContent($filePath)
    {
        return file_get_contents($filePath);
    }


    //--------------------------------------------delete file/dir functions---------------------------------------------
    public function deleteZipFile($fileName)
    {
        if (is_file($this->zipFilesDir . $fileName))
            unlink($this->zipFilesDir . $fileName);
    }

    public function deleteUnpackedFile($fileName)
    {
        if (is_file($this->unpackedFilesDir . $fileName))
            unlink($this->unpackedFilesDir . $fileName);
    }

    public function deleteTemporaryFile($fileName)
    {
        if (is_file($this->temporaryFilesDir . $fileName))
            unlink($this->temporaryFilesDir . $fileName);
    }

    public function deleteUnpackedFilesDir()
    {
        $dir = $this->unpackedFilesDir;
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    public function deleteZipFilesDir()
    {
        $dir = $this->zipFilesDir;
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    public function deleteTemporaryFilesDir()
    {
        $dir = $this->temporaryFilesDir;
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }


    //-------------------------zip functions----------------------------------------------------------------------------
    function unpackZipFile($fileName)
    {
        $zip = new ZipArchive();
        $fileName = $this->getZipFilePathByName($fileName);

        if ($zip->open($fileName) !== TRUE) {
            echo "File not found<br>";
        } else {
            set_time_limit(5000);
            $zip->extractTo($this->unpackedFilesDir);
            $zip->close();
        }
    }


    //--------------------------xml functions---------------------------------------------------------------------------
    public function loadXml($fileName)
    {
        $xmlObiect = simplexml_load_file($fileName);
        return $xmlObiect;
    }

    public function getXmlNamespaces($fileName)
    {
        $xmlNamespaces = $this->loadXml($fileName)->getNamespaces(true);
        return $xmlNamespaces;
    }

    public function getXmlName($fileName)
    {
        $xmlName= $this->loadXml($fileName);
        $xmlName =  $xmlName->getName();
        return $xmlName;
    }


    public function getXmlLength($fileName)
    {
        $xmlObiect = $this->loadXml($fileName);
        if (!empty(count($xmlObiect->children($this->getXmlNamespaces($fileName)[current(array_keys($this->getXmlNamespaces($fileName)))])))) {
            $xmlLength = count($xmlObiect->children($this->getXmlNamespaces($fileName)[current(array_keys($this->getXmlNamespaces($fileName)))]));
            return $xmlLength;
        }
        return;
    }


    public function converXmlToArray($fileName)
    {



        echo "<b>Parsowanie pliku = </b>" . $fileName . "<br>";


        if (file_exists($this->temporaryFilesDir))
            $fileName = $this->temporaryFilesDir . $fileName;
        else
            $fileName = $this->unpackedFilesDir . $fileName;


        $xmlObiect = $this->loadXml($fileName);
        $xmlNamespaces = $this->getXmlNamespaces($fileName);
        $xmlName = $this->getXmlName($fileName);


        if($xmlName=="lista-ulic" ||  $xmlName=="lista-miejscowosci");
        else
            return ;






        if (!empty($xmlLength = $this->getXmlLength($fileName))) {

            if (!empty($xmlLength)) {

                $time_start = microtime(true);

                for ($i = 0; $i < $xmlLength; $i++) {

                    $adres = $xmlObiect->children($xmlNamespaces[current(array_keys($xmlNamespaces))])[$i]->children($xmlNamespaces[current(array_keys($xmlNamespaces))]);



                        $cyklZyciaDo[] = (string)$adres->cyklZyciaDo;
                        $cyklZyciaOd[] = (string)$adres->cyklZyciaOd;

                        $wojIdTeryt[] = (string)$adres->wojIdTeryt;
                        $wojNazwa[] = (string)$adres->wojNazwa;
                        $wojIIPWersja[] = (string)$adres->wojIIPWersja;
                        $wojIIPPn[] = (string)$adres->wojIIPPn;
                        $wojIIPId[] = (string)$adres->wojIIPId;

                        $powIdTeryt[] = (string)$adres->powIdTeryt;
                        $powNazwa[] = (string)$adres->powNazwa;
                        $powIIPWersja[] = (string)$adres->powIIPWersja;
                        $powIIPPn[] = (string)$adres->powIIPPn;
                        $powIIPId[] = (string)$adres->powIIPId;

                        $gmIdTeryt[] = (string)$adres->gmIdTeryt;
                        $gmNazwa[] = (string)$adres->gmNazwa;
                        $gmIIPWersja[] = (string)$adres->gmIIPWersja;
                        $gmIIPPn[] = (string)$adres->gmIIPPn;
                        $gmIIPId[] = (string)$adres->gmIIPId;

                        $miejscIdTeryt[] = (string)$adres->miejscIdTeryt;
                        $miejscNazwa[] = (string)$adres->miejscNazwa;
                        $miejscRodzaj[] = (string)$adres->miejscRodzaj;
                        $miejscIIPWersja[] = (string)$adres->miejscIIPWersja;
                        $miejscIIPPn[] = (string)$adres->miejscIIPPn;
                        $miejscIIPId[] = (string)$adres->miejscIIPId;



                        $nrUlicy[] = (string)$adres->nrUlicy;
                        $ulIdTeryt[] = (string)$adres->ulIdTeryt;
                        $ulNazwaGlowna[] = (string)$adres->ulNazwaGlowna;
                        $ulTyp[] = (string)$adres->ulTyp;
                        $ulIIPWersja[] = (string)$adres->ulIIPWersja;
                        $ulIIPPn[] = (string)$adres->ulIIPPn;
                        $ulIIPId[] = (string)$adres->ulIIPId;
                    }

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start) / 360;
                echo '<b>Czas przetwarzania pliku = </b> ' . $execution_time . ' Sec' . "<br>";
            }

            return [

                'wojIdTeryt' => $wojIdTeryt,
                'wojNazwa' => $wojNazwa,
                'wojIIPWersja' => $wojIIPWersja,
                'wojIIPPn' => $wojIIPPn,
                'wojIIPId' => $wojIIPId,

                'powIdTeryt' => $powIdTeryt,
                'powNazwa' => $powNazwa,
                'powIIPWersja' => $powIIPWersja,
                'powIIPPn' => $powIIPPn,
                'powIIPId' => $powIIPId,

                'gmIdTeryt' => $gmIdTeryt,
                'gmNazwa' => $gmNazwa,
                'gmIIPWersja' => $gmIIPWersja,
                'gmIIPPn' => $gmIIPPn,
                'gmIIPId' => $gmIIPId,

                'miejscIdTeryt' => $miejscIdTeryt,
                'miejscNazwa' => $miejscNazwa,
                'miejscRodzaj' => $miejscRodzaj,
                'miejscIIPWersja' => $miejscIIPWersja,
                'miejscIIPPn' => $miejscIIPPn,
                'miejscIIPId' => $miejscIIPId,

                'cyklZyciaDo' => $cyklZyciaDo,
                'cyklZyciaOd' => $cyklZyciaOd,

                'ulIdTeryt' => $ulIdTeryt,
                'ulNazwaGlowna' => $ulNazwaGlowna,
                'nrUlicy' => $nrUlicy,
                'ulTyp' => $ulTyp,
                'ulIIPWersja' => $ulIIPWersja,
                'ulIIPPn' => $ulIIPPn,
                'ulIIPId' => $ulIIPId,


                'xmlLength' => $xmlLength,
                'xmlNamespaces' => $xmlNamespaces,
                'xmlName' => $xmlName

            ];
        } else
            return;
    }

    public function importXml($fileName)
    {

        $time_start = microtime(true);
        if (!empty($adres = $this->converXmlToArray($fileName))) {

            $wojewodztwaRepo = $this->entityManager->getRepository(Wojewodztwa::class);
            $powiatyRepo = $this->entityManager->getRepository(Powiaty::class);
            $gminyRepo = $this->entityManager->getRepository(Gminy::class);
            $miejscowosciRepo = $this->entityManager->getRepository(Miejscowosci::class);
            $uliceRepo = $this->entityManager->getRepository(Ulice::class);

            $user = $this->authService->getIdentity();
            $xmlName = $adres['xmlName'];
            $time_start = microtime(true);


            for ($i = 0; $i < $adres['xmlLength']; $i++) {

                //echo $i."<br>";

                $wojewodztwa = new Wojewodztwa();

                $wojewodztwa->setwojIdTeryt($adres['wojIdTeryt'][$i]);
                $wojewodztwa->setwojNazwa($adres['wojNazwa'][$i]);
                $wojewodztwa->setwojIIPWersja($adres['wojIIPWersja'][$i]);
                $wojewodztwa->setwojIIPPn($adres['wojIIPId'][$i]);
                $wojewodztwa->setwojIIPIdt($adres['wojIIPId'][$i]);
                $wojewodztwa->setAddedBy($user);
                $wojewodztwa->setModifyBy($user);

                $wojIdTeryt = $wojewodztwaRepo->findOneBy(['wojIdTeryt' => $adres['wojIdTeryt'][$i]]);
                if ($wojIdTeryt == null) {
                    // Add the entity to the entity manager.
                    $this->entityManager->persist($wojewodztwa);
                    // Apply changes to database.
                    $this->entityManager->flush();
                }
                unset($wojewodztwa);


                $powiaty = new Powiaty();

                $powiaty->setpowIdTeryt($adres['powIdTeryt'][$i]);
                $powiaty->setwojIdTeryt($adres['wojIdTeryt'][$i]);
                $powiaty->setpowNazwa($adres['powNazwa'][$i]);
                $powiaty->setpowIIPWersja($adres['powIIPWersja'][$i]);
                $powiaty->setpowIIPPn($adres['powIIPPn'][$i]);
                $powiaty->setpowIIPId($adres['powIIPId'][$i]);
                $powiaty->setAddedBy($user);
                $powiaty->setModifyBy($user);

                $powIdTeryt = $powiatyRepo->findOneBy(['powIdTeryt' => $adres['powIdTeryt'][$i]]);
                if ($powIdTeryt == null) {
                    // Add the entity to the entity manager.
                    @$this->entityManager->persist($powiaty);
                    // Apply changes to database.
                    @$this->entityManager->flush();
                }
                unset($powiaty);


                $gminy = new Gminy();
                $gminy->setgmIdTeryt($adres['gmIdTeryt'][$i]);
                $gminy->setpowIdTeryt($adres['powIdTeryt'][$i]);
                $gminy->setgmNazwa($adres['gmNazwa'][$i]);
                $gminy->setgmIIPWersja($adres['gmIIPWersja'][$i]);
                $gminy->setgmIIPPn($adres['gmIIPPn'][$i]);
                $gminy->setgmIIPIdt($adres['gmIIPId'][$i]);
                $gminy->setAddedBy($user);
                $gminy->setModifyBy($user);

                $gmIdTeryt = $gminyRepo->findOneBy(['gmIdTeryt' => $adres['gmIdTeryt'][$i]]);
                if ($gmIdTeryt == null) {
                    // Add the entity to the entity manager.
                    @$this->entityManager->persist($gminy);
                    // Apply changes to database.
                    @$this->entityManager->flush();
                }
                unset($gminy);


//-----------------------------------------Logika dla aktualizacji miejscowości -------------------------------------------------

                //Aktualizuj miejscowosci tylko wtedy gdy to paczka z miejscowosciami
                if ($xmlName == 'lista-miejscowosci') {

                    //Dodaje tylko wtedy gdy istnieje gmina dla miejscowossci w bazie
                    //$gm = $gminyRepo->findOneBy(['gmIdTeryt' => $adres['gmIdTeryt'][$i]]);

                    //if ($gm)
                    //{
                    //Dodaje tylko aktualne rekordy z pliku xml
                    if ($adres['cyklZyciaDo'][$i] == null) {

                        // $mc = $miejscowosciRepo->findOneBy(['miejscIIPId' => $adres['miejscIIPId'][$i]]);

                        // Do poprawki baza danych (mogą być różne IdTeryt)!
                          $mc2 = $miejscowosciRepo->findOneBy(['miejscIdTeryt' => $adres['miejscIdTeryt'][$i]]);


                        //Jesli tego rekordu nie ma to dodaje
                          if ((!$mc2))
                         {
                        $miejscowosci = new Miejscowosci();

                        $miejscowosci->setmiejscIdTeryt($adres['miejscIdTeryt'][$i]);
                        $miejscowosci->setgmIdTeryt($adres['gmIdTeryt'][$i]);
                        $miejscowosci->setmiejscNazwa($adres['miejscNazwa'][$i]);
                        $miejscowosci->setmiejscRodzaj($adres['miejscRodzaj'][$i]);
                        $miejscowosci->setmiejscIIPWersja($adres['miejscIIPWersja'][$i]);
                        $miejscowosci->setmiejscIIPId($adres['miejscIIPId'][$i]);
                        $miejscowosci->setmiejscIIPPn($adres['miejscIIPPn'][$i]);
                        $miejscowosci->setcyklZyciaOd($adres['cyklZyciaOd'][$i]);
                        $miejscowosci->setcyklZyciaDo($adres['cyklZyciaDo'][$i]);
                        $miejscowosci->setAddedBy($user);
                        $miejscowosci->setModifyBy($user);

                        $this->entityManager->persist($miejscowosci);
                        $this->entityManager->flush();
                        unset($miejscowosci);

                        }
                        // }

                        //Usuwam nieaktualne rekordy z bazy danych.
                        // if ($adres['cyklZyciaDo'][$i] != null) {

                        //  $ul = $uliceRepo->findOneBy(['ulIIPId' => $adres['ulIIPId'][$i]]);

                        // if ($ul) {
                        //        $this->entityManager->remove($ul);
                        //         $this->entityManager->flush();
                        //   }
                        // }


                    }
                }


//----------------------------------------------------------------------------------------------------------------------


//-----------------------------------------Logika dla aktualizacji ulic -------------------------------------------------


                //Aktualizuj ulice tylko wtedy gdy to paczka z ulicami
                if ($xmlName == 'lista-ulic') {
                    //Sprawdzam czy istnieje miejscowosc dla ulicy
                    $mc = $miejscowosciRepo->findOneBy(['miejscIdTeryt' => $adres['miejscIdTeryt'][$i]]);

                    //Jeśli nie ma to dodaje miejscowosc dla ulicy
                    if (!$mc) {
                        $miejscowosci = new Miejscowosci();

                        $miejscowosci->setmiejscIdTeryt($adres['miejscIdTeryt'][$i]);
                        $miejscowosci->setgmIdTeryt($adres['gmIdTeryt'][$i]);
                        $miejscowosci->setmiejscNazwa($adres['miejscNazwa'][$i]);
                        $miejscowosci->setmiejscRodzaj($adres['miejscRodzaj'][$i]);
                        $miejscowosci->setmiejscIIPWersja($adres['miejscIIPWersja'][$i]);
                        $miejscowosci->setmiejscIIPId($adres['miejscIIPId'][$i]);
                        $miejscowosci->setmiejscIIPPn($adres['miejscIIPPn'][$i]);
                        $miejscowosci->setAddedBy($user);
                        $miejscowosci->setModifyBy($user);

                        $this->entityManager->persist($miejscowosci);
                        $this->entityManager->flush();
                        unset($miejscowosci);
                    }

                    //Dodaje tylko wtedy gdy istnieje miejscowosc dla ulicy w bazie
                    if ($mc) {

                        //Dodaje aktualne rekordy do bazy, jeśli jeszcze ich nie ma w bazie.
                        if ($adres['cyklZyciaDo'][$i] == null) {


                            $ul = $uliceRepo->findOneBy(['ulIIPId' => $adres['ulIIPId'][$i]]);
                            //Jesli tego rekordu nie ma to dodaje
                            if (!$ul) {
                                $ulice = new Ulice();

                                $ulice->setulIdTeryt($adres['ulIdTeryt'][$i]);
                                $ulice->setmiejscIdTeryt($adres['miejscIdTeryt'][$i]);
                                $ulice->setnrUlicy($adres['nrUlicy'][$i]);
                                $ulice->setulNazwaGlowna($adres['ulNazwaGlowna'][$i]);
                                $ulice->setulTyp($adres['ulTyp'][$i]);
                                $ulice->setulIIPWersja($adres['ulIIPWersja'][$i]);
                                $ulice->setulIIPPn($adres['ulIIPPn'][$i]);
                                $ulice->setulIIPId($adres['ulIIPId'][$i]);
                                $ulice->setcyklZyciaOd($adres['cyklZyciaOd'][$i]);
                                $ulice->setcyklZyciaDo($adres['cyklZyciaDo'][$i]);
                                $ulice->setAddedBy($user);
                                $ulice->setModifyBy($user);


                                $this->entityManager->persist($ulice);
                                $this->entityManager->flush();
                            }
                        }
                    }

                    //Usuwam nieaktualne rekordy z bazy danych.
                    if ($adres['cyklZyciaDo'][$i] != null) {


                        $ul = $uliceRepo->findOneBy(['ulIIPId' => $adres['ulIIPId'][$i]]);


                        if ($ul) {
                            $this->entityManager->remove($ul);
                            $this->entityManager->flush();
                        }
                    }

                    unset($ulice);

                }

            }

//----------------------------------------------------------------------------------------------------------------------

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start) / 360;
            echo '<b>Czas wrzucania pliku do bazy = </b>' . $execution_time . ' Sec <br><hr>';
        }
    }










                // DZIAŁAJĄCE USUWANIE REKORDU Z BAZY

                /*
                $ul = $uliceRepo->findOneBy(['ulNazwaGlowna' => 'Osiedle II']);
                var_dump($ul);

                $this->entityManager->remove($ul);
                $this->entityManager->flush();
                */


                // DZIAŁAJĄCA AKTUALIYACJA REKORDU W BAZIE

                /*
                $ul = $uliceRepo->findOneBy(['ulNazwaGlowna' => 'Osiedle II']);
                var_dump($ul);
                $ul->setulNazwaGlowna('New product name!');
                $this->entityManager->flush();
                */













    public function importZip($fileName)
    {
        $fileName = $this->getZipFilePathByName($fileName);


        $zip = new ZipArchive();
        if ($zip->open($fileName) !== TRUE)
        {
            echo "File not found<br>";
            return;
        }
        else
        {
            set_time_limit(5000);
            $zip->extractTo($this->temporaryFilesDir);
            $zip->close();
        }


        $files = array();
        $handle  = opendir($this->temporaryFilesDir);
        while (false !== ($entry = readdir($handle))) {

            if($entry=='.' || $entry=='..')
                continue; // Skip current dir and parent dir.

            $files[] = $entry;
        }


        // Return the list of uploaded files.
        //return $files;
        $time_start = microtime(true);

        foreach($files as $file)
        {

           $this->importXml($file);

        }
        $time_end = microtime(true);



        $execution_time = ($time_end - $time_start)/360;


        $dir = $this->temporaryFilesDir;
            foreach(scandir($dir) as $file) {
                if ('.' === $file || '..' === $file) continue;
                if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
                else unlink("$dir/$file");
            }
            rmdir($dir);
        }

}












