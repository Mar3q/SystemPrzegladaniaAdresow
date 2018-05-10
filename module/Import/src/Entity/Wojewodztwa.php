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

     */
    protected $wojIdTeryt;
    /** 
     * @ORM\Column(name="wojNazwa")
     */

    protected $wojNazwa ;
    
    /** 
     * @ORM\Column(name="wojIIPWersja")
     */
    protected  	$wojIIPWersja ;

    /** 
     * @ORM\Column(name="wojIIPPn")
     */
    protected $wojIIPPn;

    /** 
     * @ORM\Column(name="wojIIPId")
     */
    protected $wojIIPId ;

    /**
     * @ORM\Column(name="added_by")
     */
    protected $addedBy;

    /**
     * @ORM\Column(name="modify_by")
     */
    protected $modifyBy;


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



