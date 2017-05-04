<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 3/28/17
 * Time: 11:46 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Gruppi;
use AppBundle\Form\GruppiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Groups controller.
 *
 * @Route("gruppi")
 */
class GruppiController extends Controller
{
    /**
     * Lists all team entities.
     *
     * @Route("/", name="group_init",options={"expose"=true})
     * @Method("GET")
     */
    public function initAction()
    {
        return $this->render('@App/base.html.twig');
    }
    /**
     * Lists all team entities.
     *
     * @Route("/index", name="group_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('AppBundle:Gruppi')->findAll();
        return $this->render('AppBundle:gruppi:index.html.twig', array(
            'groups' => $groups
        ));
    }
    /**
     * Displays a form to edit an existing group entity.
     * @Route("/{id}/edit", name="gruppi_edit",options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Gruppi $gruppo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Gruppi $gruppo)
    {
        $form = $this->createForm('AppBundle\Form\GruppiType', $gruppo, array(
            'action' => $this->generateUrl('gruppi_edit', array('id' => $gruppo->getId()))));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $persone=$gruppo->getElencoPersone();
                $em = $this->getDoctrine()->getManager();
                $em->flush($gruppo);
                foreach ($persone as $persona){
                    $em->flush($persona);
                }
                return $this->redirect($this->generateUrl('group_index'));
            } else {
//                // esperimenti vari
//                //evaluate expression: $form->getViewData()->getElencoPersone()[0]->getEmail()
//                var_dump($form['descrizione']->getErrors());   //dedotto guardando chi sono i CHILD di $form
//                var_dump($form['descrizione']->getErrors());
//                var_dump($form->getErrors());
//                die;
//                // tentativo di visualizzare errore nel twig
//                return new Response(
//                    $this->renderView('AppBundle:gruppi:error.html.twig',
//                        array(
//                            'gruppo' => $gruppo,
//                            'form' => $form->createView()
//                        )
//                    )
//                );
                return new Response(

                    $this->renderView('AppBundle:gruppi:edit.html.twig',
                      array(
                        'gruppo' => $gruppo,
                        'form' => $form->createView()
                      )
                    )
                    , 409
                );
            }
        }
        return $this->render('AppBundle:gruppi:edit.html.twig', array(
            'gruppo' => $gruppo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new group entity.
     *
     * @Route("/new", name="group_new",options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $groups = new Gruppi();

        $form = $this->createForm('AppBundle\Form\GruppiType', $groups, array(
            'action' => $this->generateUrl('group_new')));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($groups);
                $em->flush($groups);

                return $this->redirect($this->generateUrl('group_index'));
            } else {
                return new Response(
                    $this->renderView('AppBundle:gruppi:new.html.twig', array(
                        '$groups' => $groups,
                        'form' => $form->createView()
                    ))
                    , 409);
            }
        }

        return $this->render('AppBundle:gruppi:new.html.twig', array(
            '$groups' => $groups,
            'form' => $form->createView(),
        ));
    }

}