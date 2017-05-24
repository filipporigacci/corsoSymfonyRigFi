<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persone
 *
 * @ORM\Table(name="persone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersoneRepository")
 */
class Persone
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;
    /**
     * @var Gruppi
     *
     * In 8° lezione (28/3/2017 esercizio n. 2) ha modificato da arrobaORM\ManyToOne(targetEntity="AppBundle\Entity\Gruppi")
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/working-with-associations.html
     * Bidirectional - Many Comments are authored by one user (OWNING SIDE)
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Gruppi",inversedBy="elencoPersone")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_gruppo", referencedColumnName="id")
     * })
     */
    private $idGruppo;

    /**
     * @var Squadre
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Squadre",inversedBy="elencoPersone")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_squadra", referencedColumnName="id")
     * })
     */
    private $idSquadra;

    /**
     * @var string
     *
     * @ORM\Column(name="cognome", type="string", length=255)
     */
    private $cognome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataNascita", type="date")
     */
    private $dataNascita;

    /**
     * @var string
     *
     * @ORM\Column(name="codiceFiscale", type="string", length=26, unique=true)
     */
    private $codiceFiscale;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255 )
     */
    private $email;

    /**
     * Get id
     *
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
     * Set nome
     *
     * @param string $nome
     *
     * @return Persone
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cognome
     *
     * @param string $cognome
     *
     * @return Persone
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;

        return $this;
    }

    /**
     * Get cognome
     *
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * Set dataNascita
     *
     * @param \DateTime $dataNascita
     *
     * @return Persone
     */
    public function setDataNascita($dataNascita)
    {
        $this->dataNascita = $dataNascita;

        return $this;
    }

    /**
     * Get dataNascita
     *
     * @return \DateTime
     */
    public function getDataNascita()
    {
        return $this->dataNascita;
    }

    /**
     * Set codiceFiscale
     *
     * @param string $codiceFiscale
     *
     * @return Persone
     */
    public function setCodiceFiscale($codiceFiscale)
    {
        $this->codiceFiscale = $codiceFiscale;

        return $this;
    }

    /**
     * Get codiceFiscale
     *
     * @return string
     */
    public function getCodiceFiscale()
    {
        return $this->codiceFiscale;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Persone
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @return Gruppi
     */
    public function getIdGruppo()
    {
        return $this->idGruppo;
    }

    /**
     * @param Gruppi $idGruppo
     */
    public function setIdGruppo($idGruppo)
    {
        $this->idGruppo = $idGruppo;
    }

    /**
     * @return Squadre
     */
    public function getIdSquadra()
    {
        return $this->idSquadra;
    }

    /**
     * @param Squadre $idSquadra
     */
    public function setIdSquadra($idSquadra)
    {
        $this->idSquadra = $idSquadra;
    }
}
