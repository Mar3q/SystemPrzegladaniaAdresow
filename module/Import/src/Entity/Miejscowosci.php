<?php
namespace Import\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Search\Repository\WojewodztwaRepository")
 * @ORM\Table(name="miejscowosci")
 */
class Miejscowosci
{
    // User status constants.

    /**
     * @ORM\Id
     * @ORM\Column(name="miejscIdTeryt")

     */
    protected $miejscIdTeryt;

    /**
     * @ORM\Column(name="gmIdTeryt")
     */

    protected $gmIdTeryt ;


    /** 
     * @ORM\Column(name="miejscNazwa")
     */

    protected $miejscNazwa ;
    
    /** 
     * @ORM\Column(name="miejscRodzaj")
     */
    protected $miejscRodzaj;

    /**
     * @ORM\Column(name="miejscIIPWersja")
     */

    protected  	$miejscIIPWersja;

    /**
     * @ORM\Column(name="miejscIIPPn")
     */
    protected $miejscIIPPn;

    /**
     * @ORM\Column(name="miejscIIPId")
     */
    protected $miejscIIPId;

    /**
     * @ORM\Column(name="cyklZyciaDo")
     */
    protected $cyklZyciaDo;

    /**
     * @ORM\Column(name="cyklZyciaOd")
     */
    protected $cyklZyciaOd;


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



    public function getmiejscIdTeryt(){
        return $this->miejscIdTeryt;
    }
    public function setmiejscIdTeryt($miejscIdTeryt)
    {
        $this->miejscIdTeryt = $miejscIdTeryt;
    }

    public function getgmIdTeryt()
    {
        return $this->gmIdTeryt;
    }

    public function setgmIdTeryt($gmIdTeryt)
    {
        $this->gmIdTeryt= $gmIdTeryt;
    }

    public function getmiejscNazwa(){
        return $this->miejscNazwa;
    }
    public function setmiejscNazwa($miejscNazwa){
        $this->miejscNazwa = $miejscNazwa;
    }

    public function getmiejscRodzaj(){
        return $this->miejscRodzaj;
    }
    public function setmiejscRodzaj($miejscRodzaj){
        $this->miejscRodzaj = $miejscRodzaj;
    }

    public function getmiejscIIPWersja(){
        return $this->miejscIIPWersja;
    }
    public function setmiejscIIPWersja($miejscIIPWersja){
        $this->miejscIIPWersja = $miejscIIPWersja;
    }

    public function getmiejscIIPPn(){
        return $this->miejscIIPPn;
    }
    public function setmiejscIIPPn($miejscIIPPn){
        $this->miejscIIPPn = $miejscIIPPn;
    }

    public function getmiejscIIPId(){
        return $this->miejscIIPId;
    }
    public function setmiejscIIPId($miejscIIPId){
        $this->miejscIIPId = $miejscIIPId;
    }

    public function getcyklZyciaDo(){
        return $this->cyklZyciaDo;
    }
    public function setcyklZyciaDo($cyklZyciaDo){
        $this->cyklZyciaDo = $cyklZyciaDo;
    }

    public function getcyklZyciaOd(){
        return $this->cyklZyciaOd;
    }
    public function setcyklZyciaOd($cyklZyciaOd){
        $this->cyklZyciaOd = $cyklZyciaOd;
    }


}



