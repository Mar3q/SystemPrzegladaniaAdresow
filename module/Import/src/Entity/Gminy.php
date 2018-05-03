<?php
namespace Import\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity
 * @ORM\Table(name="gminy")
 */
class Gminy
{
    // User status constants.

    /**
     * @ORM\Id
     * @ORM\Column(name="gmIdTeryt")

     */
    protected $gmIdTeryt;
    /**
     * @ORM\Column(name="powIdTeryt")
     */

    protected $powIdTeryt ;



    /** 
     * @ORM\Column(name="gmNazwa")
     */

    protected $gmNazwa ;
    
    /** 
     * @ORM\Column(name="gmIIPWersja")
     */
    protected  	$gmIIPWersja ;

    /** 
     * @ORM\Column(name="gmIIPPn")
     */
    protected $gmIIPPn;

    /** 
     * @ORM\Column(name="gmIIPId")
     */
    protected $gmIIPId ;

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


    public function getgmIdTeryt()
    {
        return $this->gmIdTeryt;
    }

    public function setgmIdTeryt($gmIdTeryt)
    {
        $this->gmIdTeryt= $gmIdTeryt;
    }

    public function getpowIdTeryt(){
        return $this->powIdTeryt;
    }
    public function setpowIdTeryt($powIdTeryt){
        $this->powIdTeryt= $powIdTeryt;
    }

    public function getgmNazwa()
    {
        return $this->gmNazwa;
    }

    public function setgmNazwa($gmNazwa)
    {
        $this->gmNazwa = $gmNazwa;
    }
    

    public function getgmIIPWersja()
    {
        return $this->gmIIPWersja;
    }       


    public function setgmIIPWersja($gmIIPWersja)
    {
        $this->gmIIPWersja = $gmIIPWersja;
    }
    

    public function getgmIIPPn()
    {
        return $this->gmIIPPn;
    }

    public function setgmIIPPn($gmIIPPn)
    {
        $this->gmIIPPn = $gmIIPPn;
    }


    public function getgmIIPIdt()
    {
        return $this->twojIIPIdt;
    }

    public function setgmIIPIdt($gmIIPIdt)
    {
        $this->gmIIPId = $gmIIPIdt;
    }



}



