<?php
namespace Import\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity
 * @ORM\Table(name="powiaty")
 */
class Powiaty
{
    // User status constants.

    /**
     * @ORM\Id
     * @ORM\Column(name="powIdTeryt")

     */
    protected $powIdTeryt;

    /**
     * @ORM\Column(name="wojIdTeryt")
     */

    protected $wojIdTeryt ;

    /** 
     * @ORM\Column(name="powNazwa")
     */

    protected $powNazwa ;
    
    /** 
     * @ORM\Column(name="powIIPWersja")
     */
    protected  	$powIIPWersja ;

    /** 
     * @ORM\Column(name="powIIPPn")
     */
    protected $powIIPPn;

    /** 
     * @ORM\Column(name="powIIPId")
     */
    protected $powIIPId ;

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


    public function getpowIdTeryt()
    {
        return $this->powIdTeryt;
    }

    public function setpowIdTeryt($powIdTeryt)
    {
        $this->powIdTeryt= $powIdTeryt;
    }

    public function getwojIdTeryt(){
        return $this->wojIdTeryt;
    }
    public function setwojIdTeryt($wojIdTeryt){
        $this->wojIdTeryt= $wojIdTeryt;
    }

    public function getpowNazwa()
    {
        return $this->powNazwa;
    }

    public function setpowNazwa($powNazwa)
    {
        $this->powNazwa = $powNazwa;
    }
    

    public function getpowIIPWersja()
    {
        return $this->powIIPWersja;
    }       


    public function setpowIIPWersja($powIIPWersja)
    {
        $this->powIIPWersja = $powIIPWersja;
    }
    

    public function getpowIIPPn()
    {
        return $this->powIIPPn;
    }

    public function setpowIIPPn($powIIPPn)
    {
        $this->powIIPPn = $powIIPPn;
    }


    public function getpowIIPId()
    {
        return $this->powIIPIdt;
    }

    public function setpowIIPId($powIIPIdt)
    {
        $this->powIIPId = $powIIPIdt;
    }


}



