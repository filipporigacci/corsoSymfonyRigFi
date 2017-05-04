<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 3/21/17
 * Time: 11:38 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Persone
 *
 * @ORM\Table(name="gruppi")
 * @ORM\Entity()
 */
class Gruppi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descrizione", type="string", length=255)
     */
    private $descrizione;

    /**
     * @var ArrayCollection
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Persone", mappedBy="idGruppo", cascade={"persist"})
     *
     */
    private $elencoPersone;
    public function __construct()
    {
        $this->elencoPersone = new ArrayCollection();

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }
    /**
     * @param string $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return ArrayCollection
     */
    public function getElencoPersone()
    {
        return $this->elencoPersone;
    }
}