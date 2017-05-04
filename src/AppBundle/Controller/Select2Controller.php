<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Gruppi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Persone Controller
 *
 * @Route("/select2")
 *
 */
class Select2Controller extends Controller
{
    /**
     * @Route("/gruppi", name="select2_gruppi")
     * @Method("GET")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function gruppiAction(Request $request)
    {
        $termine = strtolower($request->query->get('q'));
        $data = [];
        /* eliminata perché   inutile se non dannosa (quando inserisco per esempio un valore di 'minimum_input_length' nel controller superiore a 2)
                if (strlen($termine) < 2) {
                    return JsonResponse::create($data);
                }
        */
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('g')
            ->from('AppBundle:Gruppi', 'g')
            ->where('UPPER(g.descrizione) LIKE UPPER(:descrizione)')
            ->setParameter('descrizione', '%' . $termine . '%')
            ->getQuery();
        $gruppi = $query->getResult();
        /**
         *
         * @var  $gruppo Gruppi
         */
        foreach ($gruppi as $key => $gruppo) {
            if (strpos(strtolower($gruppo->getDescrizione()), $termine) >= 0) {
                $data[] = ['id' => $gruppo->getId(), 'text' => $gruppo->getDescrizione()];
            }
        }
        return JsonResponse::create($data);
    }

    /**
     * @Route("/persone", name="select2_persone")
     * @Method("GET")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function personeAction(Request $request)
    {
        $termine = strtolower($request->query->get('q'));
        $data = [];
        /* eliminata perché   inutile se non dannosa (quando inserisco per esempio un valore di 'minimum_input_length' nel controller superiore a 2)
                if (strlen($termine) < 2) {
                    return JsonResponse::create($data);
                }*/
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('p')
            ->from('AppBundle:Persone', 'p')
            ->where('UPPER(p.cognome) LIKE UPPER(:cognome)')
            ->setParameter('cognome', '%' . $termine . '%')
            ->getQuery();
        $persone = $query->getResult();
        /**
         *
         * @var  $persona Persone
         */
        foreach ($persone as $key => $persona) {
            if (strpos(strtolower($persona->getCognome()), $termine) >= 0) {
                $data[] = ['id' => $persona->getId(), 'text' => $persona->getPersone()];
            }
        }
        return JsonResponse::create($data);
    }

    /**
     * @Route("/squadre", name="select2_squadre")
     * @Method("GET")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function squadreAction(Request $request)
    {
        $termine = strtolower($request->query->get('q'));
        $data = [];
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('s')
            ->from('AppBundle:Squadre','s')
            ->where('UPPER(s.nome) LIKE UPPER(:nome)')
            ->setParameter('nome', '%' . $termine . '%')
            ->getQuery();
        $squadre = $query->getResult();
        /**
         * @var  $squadre Squadre
         */
        foreach ($squadre as $key => $squadra) {
            if (strpos(strtolower($squadra->getNome()), $termine) >= 0) {
                $data[] = ['id' => $squadra->getId(), 'text' => $squadra->getNome()];
            }
        }
        return JsonResponse::create($data);
    }
}
