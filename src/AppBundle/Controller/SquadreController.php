<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Squadre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Squadre controller.
 *
 * @Route("squadre")
 */
class SquadreController extends Controller
{
    /**
     * Lists all squadre entities.
     *
     * @Route("/", name="squadre_init",options={"expose"=true})
     * @Method("GET")
     */
    public function initAction()
    {
        return $this->render('AppBundle::base.html.twig');
    }
    /**
     * Lists all squadre entities.
     *
     * @Route("/index", name="squadre_index",options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $squadres = $em->getRepository('AppBundle:Squadre')->findAll();
        return $this->render('AppBundle:squadre:index.html.twig', array(
            'pippes' => $squadres,
        ));
    }

    /**
     * Creates a new squadre entity.
     *
     * @Route("/new", name="squadre_new",options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $squadre = new Squadre();

        $form = $this->createForm('AppBundle\Form\SquadreType', $squadre, array(
            'action' => $this->generateUrl('squadre_new')));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($squadre);
                $em->flush($squadre);

                return $this->redirect($this->generateUrl('squadre_index'));
            } else {
                return new Response(
                    $this->renderView('AppBundle:squadre:new.html.twig', array(
                        'squadre' => $squadre,
                        'form' => $form->createView()
                    ))
                    , 409);
            }
        }

        return $this->render('AppBundle:squadre:new.html.twig', array(
            'squadre' => $squadre,
            'form' => $form->createView(),
        ));
    }

//    /**
//     * Finds and displays a persone entity.
//     *
//     * @Route("/{id}", name="persone_show", options={"expose"=true})
//     * @Method("GET")
//     */
//    public function showAction(Persone $persone)
//    {
//        $deleteForm = $this->createDeleteForm($persone);
//
//        return $this->render('persone/show.html.twig', array(
//            'persone' => $persone,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing persone entity.
     * @Route("/{id}/edit", name="squadre_edit",options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Squadre $squadre
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Squadre $squadre)
    {
        $form = $this->createForm('AppBundle\Form\SquadreType', $squadre, array(
            'action' => $this->generateUrl('squadre_edit', array('id' => $squadre->getId()))));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $persone=$squadre->getElencoPersone();
                $em = $this->getDoctrine()->getManager();
                $em->flush($squadre);
                //foreach ($persone as $persona)
                foreach ($persone as $key => $persona){
                    $em->flush($persona);
                }
                return $this->redirect($this->generateUrl('squadre_index'));
            } else {
                return new Response(
//                    $this->renderView(':squadre:error.html.twig', array(
                    $this->renderView('AppBundle:squadre:edit.html.twig', array(
                        'squadre' => $squadre,
                        'form' => $form->createView()
                    ))
                    , 409);
            }
        }
        return $this->render('AppBundle:squadre:edit.html.twig', array(
            'squadre' => $squadre,
            'form' => $form->createView(),
        ));
    }

//    /**
//     * Deletes a persone entity.
//     *
//     * @Route("/{id}", name="persone_delete",options={"expose"=true})
//     * @Method("DELETE")
//     * @param Request $request
//     * @param Persone $persone
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function deleteAction(Request $request, Persone $persone)
//    {
//        $form = $this->createDeleteForm($persone);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            /* @var $em \Doctrine\ORM\EntityManager */
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($persone);
//            $em->flush($persone);
//        }
//
//        return $this->redirectToRoute('persone_index');
//    }
//
//    /**
//     * Creates a form to delete a persone entity.
//     *
//     * @param Persone $persone The persone entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Persone $persone)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('persone_delete', array('id' => $persone->getId())))
//            ->setMethod('DELETE')
//            ->getForm();
//    }


    /**
     * Deletes a oncologiascheda entity.
     *
     * @Route("/{id}/delete", name="persone_delete", options={"expose"=true})
     * @Method({"GET","DELETE"})
     *
     * @param Request $request
     * @param Persone $persona
     *
     * @return Response
     */


//    public function deleteAction(Request $request,Persone $persona)
//    {
//
//
//
//        /* @var $em \Doctrine\ORM\EntityManager */
//        $em = $this->getDoctrine()->getManager();
//
//
//
//        if ($request->getMethod() == 'DELETE') {
//
//            $em->remove($persona);
//            $em->flush();
//
////            return $this->redirect($this->generateUrl('persone_index'));
//            return $this->indexAction();
//        }
//
//        return $this->render(':persone:delete.html.twig', array(
//            'entity' => $persona
//
//        ));
//    }





}
