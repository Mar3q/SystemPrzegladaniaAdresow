<?php
namespace Import\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Search\Repository\WojewodztwaRepository")
 * @ORM\Table(name="wojewodztwa")
 */
class Wojewodztwa
{
    // User status constants.

    /**
     * @ORM\Id
     * @ORM\Column(name="wojIdTeryt")
     * @ORM\OneToMany(targetEntity="Search\Entity\Powiaty", mappedBy="wojewodztwa")
     * @ORM\JoinColumn(name="wojIdTeryt", referencedColumnName="wojIdTeryt")

     */
    public  $wojIdTeryt;
    /** 
     * @ORM\Column(name="wojNazwa")
     */

    public $wojNazwa ;
    
    /** 
     * @ORM\Column(name="wojIIPWersja")
     */
    public   	$wojIIPWersja ;

    /** 
     * @ORM\Column(name="wojIIPPn")
     */
    public  $wojIIPPn;

    /** 
     * @ORM\Column(name="wojIIPId")
     */
    public  $wojIIPId ;

    /**
     * @ORM\Column(name="added_by")
     */
    public  $addedBy;

    /**
     * @ORM\Column(name="modify_by")
     */
    public  $modifyBy;


    public function getModifyBy(){
        return $this->modifyBy;
    }
    public function setModifyBy($modifyBy)
    {
        $this->modifyBy = $modifyBy;
    }


    public function getAddedBy(){
        return $this->addedBy;
    }
    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }


    public function getwojIdTeryt(){
        return $this->wojIdTeryt;
    }
    public function setwojIdTeryt($wojIdTeryt){
        $this->wojIdTeryt= $wojIdTeryt;
    }

    public function getwojNazwa()
    {
        return $this->wojNazwa;
    }

    public function setwojNazwa($wojNazwa)
    {
        $this->wojNazwa = $wojNazwa;
    }
    

    public function getwojIIPWersja()
    {
        return $this->wojIIPWersja;
    }       


    public function setwojIIPWersja($wojIIPWersja)
    {
        $this->wojIIPWersja = $wojIIPWersja;
    }
    

    public function getwojIIPPn()
    {
        return $this->wojIIPPn;
    }

    public function setwojIIPPn($wojIIPPn)
    {
        $this->wojIIPPn = $wojIIPPn;
    }


    public function getwojIIPIdt()
    {
        return $this->twojIIPIdt;
    }

    public function setwojIIPIdt($wojIIPIdt)
    {
        $this->wojIIPId = $wojIIPIdt;
    }


}



