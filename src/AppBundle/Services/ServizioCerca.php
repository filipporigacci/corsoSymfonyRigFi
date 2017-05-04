<?php
/**
 * Created by PhpStorm.
 * User: Tony Lorefice
 * Date: 21/02/2017
 * Time: 13:36
 */

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class ServizioCerca
{
    private $em;
    private $session;
    private $log;

    /**
     * ServizioCerca constructor.
     * @param $em
     * @param $log
     * @param $session
     */
    public function __construct(EntityManager $em, $session, LogExample $log)
    {
        $this->em = $em;
        $this->log = $log;
        $this->session = $session;
    }

    public function DBmanager($surname){
        //$people = $this->em->getRepository('AppBundle:Persone')->findAll();
        //$peopleCount = count($people);
        $this->log->log('Il servizio servizio_ricerca è stato chiamato dal controller esercizioAction della classe controller PersoneCopntroller');
        $this->log->log('URI = ./app_dev.php/persone/esercizio/'. $surname);
        $persona = $this->em->getRepository('AppBundle:Persone')->findOneByCognome($surname);
        return $persona;
    }

}