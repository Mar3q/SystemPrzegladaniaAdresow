<?php
namespace Import\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Search\Repository\WojewodztwaRepository")
 * @ORM\Table(name="ulice")
 */
class Ulice
{

    /**
     * @ORM\Id
     * @ORM\Column(name="ulIdTeryt")

     */
    protected $ulIdTeryt;

    /**
     * @ORM\Column(name="miejscIdTeryt")

     */
    protected $miejscIdTeryt;

    /**
     * @ORM\Column(name="ulNazwaGlowna")
     */

    protected $ulNazwaGlowna;

    /**
     * @ORM\Column(name="nrUlicy")
     */
    protected $nrUlicy;

    /**
     * @ORM\Column(name="ulTyp")
     */

    protected  	$ulTyp;

    /**
     * @ORM\Column(name="ulIIPWersja")
     */
    protected $ulIIPWersja;

    /**
     * @ORM\Column(name="ulIIPPn")
     */
    protected $ulIIPPn;

    /**
     * @ORM\Column(name="ulIIPId")
     */
    protected $ulIIPId;

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



    public function getulIdTeryt(){
        return $this->ulIdTeryt;
    }
    public function setulIdTeryt($ulIdTeryt)
    {
        $this->ulIdTeryt = $ulIdTeryt;
    }
    public function getmiejscIdTeryt(){
        return $this->miejscIdTeryt;
    }
    public function setmiejscIdTeryt($miejscIdTeryt)
    {
        $this->miejscIdTeryt = $miejscIdTeryt;
    }

    public function getulNazwaGlowna(){
        return $this->ulNazwaGlowna;
    }
    public function setulNazwaGlowna($ulNazwaGlowna){
        $this->ulNazwaGlowna = $ulNazwaGlowna;
    }

    public function getnrUlicy(){
        return $this->nrUlicy;
    }
    public function setnrUlicy($nrUlicy){
        $this->nrUlicy = $nrUlicy;
    }

    public function getulTyp(){
        return $this->ulTyp;
    }
    public function setulTyp($ulTyp){
        $this->ulTyp = $ulTyp;
    }

    public function getulIIPWersja(){
        return $this->ulIIPWersja;
    }
    public function setulIIPWersja($ulIIPWersja){
        $this->ulIIPWersja = $ulIIPWersja;
    }

    public function getulIIPPn(){
        return $this->ulIIPPn;
    }
    public function setulIIPPn($ulIIPPn){
        $this->ulIIPPn = $ulIIPPn;
    }

    public function getulIIPId(){
        return $this->ulIIPId;
    }
    public function setulIIPId($ulIIPId){
        $this->ulIIPId = $ulIIPId;
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




