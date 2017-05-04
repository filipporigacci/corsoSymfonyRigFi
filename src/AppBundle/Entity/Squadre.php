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
 * Squadre
 *
 * @ORM\Table(name="squadre")
 * @ORM\Entity()
 */
class Squadre
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
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Persone", mappedBy="idSquadra", cascade={"persist"})
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

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

//    /**
//     * @param ArrayCollection $elencoPersone
//     */
//    public function setElencoPersone($elencoPersone)
//    {
//        $this->elencoPersone = $elencoPersone;
//    }








}