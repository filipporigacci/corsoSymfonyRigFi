<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Persone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Persone controller.
 *
 * @Route("home")
 * commentato arrobaRoute("persone")
 */
class PersoneController extends Controller
{
    /**
     * Creata a mano il 2017/03/14 (Lez n 6)
     *
     * @Route("/", name="persone_init", options={"expose"=true})
     * @Method("GET")
     */

    public function initAction()
    {
        return $this->render('@App/base.html.twig');
    }

    /**
     * Lists all persone entities.
     *
     * @Route("/index", name="persone_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $persones = $em->getRepository('AppBundle:Persone')->findAll();
        return $this->render('AppBundle:persone:index.html.twig', array('persones' => $persones,));
    }


    /**
     *
     * @Route("/esercizio/{surname}")
     * @Method("GET")
     */
    public function esercizioAction($surname)
    {
        /*
            // Esercizio numero 1 dopo la prima lezione
            // Salutare il cognome immesso se esiste in db altrimenti invitarlo
            $em = $this->getDoctrine()->getManager();
            //$persones = $em->getRepository('AppBundle:Persone')->findAll();
            $people = $em->getRepository('AppBundle:Persone')->findOneByCognome($surname);

            // Verifica esercizio: OK! Però se avessi voluto gestire il ritorno dal db nel COntroller, avrei dovuto fare come segue:
            //$trovato=count($people);
            // Poi nel twig metterei lo IF in base al valore di $trovato (vero o falso)

            return $this->render('@App/Default/indexEsercizio.html.twig', array(
                'people'  => $people,
                'surname' => $surname,
            ));
        */


        // Secondo esempio della terza lezione (sui servizi)
        // Il primo (scrittura diretta nel file di log) l'ho inserito nei controller che eseguono l'inserimento, la cancellazione e la modifica delle anagrafiche
        // Il secondo esempio lo lascio così com'é stato svolto a Pisa: inserire nel file di log un messaggio ma attraverso un altro servizio
        $persona = $this->get('servizio_ricerca')->DBmanager($surname);
        //return $this->render('@App/persone/index.html.twig', array('persones' => $people,));

        return $this->render('@App/Default/indexEsercizio.html.twig', array('people' => $persona,'surname' => $surname,));

    }

    /**
     *
     * @Route("/stampatabella")
     * @Method("GET")
     */
    public function stampaTabellaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('AppBundle:Persone')->findAll();
        $fields= array('nome','cognome');
        return $this->render('AppBundle:persone:tabellaTwigExtension.html.twig',
            array(
                'persone' => $people,
                'campi' => $fields
            )
        );
    }

    /**
     * Creates a new persone entity.
     *
     * @Route("/new", name="persone_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
//      Anche newAction è stata cambiata il 7/3/2017 (lez n 5) secondo lo stesso proncipio con cui ha modificato editAction
//      Altrimenti avrei avuto:
//      ERROR - Uncaught PHP Exception Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException: "No route found for "POST /persone/":
//      Method Not Allowed (Allow: GET, HEAD)" at C:\xampp\htdocs\corsoSymfony_3.2_git\var\cache\dev\classes.php line 3489
        $persone = new Persone();
//      variazione del 7/3/2017 (lez n 5)
//      $form = $this->createForm('AppBundle\Form\PersoneType', $persone);
        $form = $this->createForm('AppBundle\Form\PersoneType',$persone,array('action' => $this->generateUrl('persone_new')));
        $form->handleRequest($request);

//      Sostituzione del controllo del 14/3/2017 lez n 6
/*

         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($persone);
            $em->flush($persone);
            // variazione del 7/3/2017 (lez n 5)
            //return $this->redirectToRoute('persone_show', array('id' => $persone->getId()));
            return $this->redirect($this->generateUrl('persone_index'));
        }
*/
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // @var $em \Doctrine\ORM\EntityManager
                $em = $this->getDoctrine()->getManager();
                $em->persist($persone);
                $em->flush($persone);
                // mio esercizio sui log
                $this->get('log_example_test')->log('Creata nuova anagrafica '.$persone->getCodiceFiscale());
                return $this->redirect($this->generateUrl('persone_index'));
            } else {
                return new Response(
                    $this->renderView('AppBundle:persone:new.html.twig', array(
                        'persone' => $persone,
                        'form' => $form->createView()
                    ))
                    , 409);
            }
        }
        return $this->render('@App/persone/new.html.twig', array('persone' => $persone,'form' => $form->createView(),));
    }

    /**
     * Finds and displays a persone entity.
     *
     * @Route("/{id}", name="persone_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Persone $persone)
    {
        // Dopo l'esercizio di ripristino della funzione 'delete record' del 28/3/2017 con Licari la parte che segue non serve più
        //$deleteForm = $this->createDeleteForm($persone);
        //return $this->render('@App/persone/show.html.twig', array('persone' => $persone,'delete_form' => $deleteForm->createView(),));
        return $this->render('@App/persone/show.html.twig', array('persone' => $persone,));
    }

    /**
     * Displays a form to edit an existing persone entity.
     *
     * @Route("/{id}/edit", name="persone_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Persone $persone)
    {
//      lezione n 5 del 2017/3/7: stravolto editAction (secondo me lo ha fatto seguendo quanto era già scritto in newAction)
        /*
                $deleteForm = $this->createDeleteForm($persone);
                $editForm = $this->createForm('AppBundle\Form\PersoneType',$persone);
                $editForm->handleRequest($request);
        */
        $form = $this->createForm('AppBundle\Form\PersoneType',$persone,array('action' => $this->generateUrl('persone_edit',array('id'=>$persone->getId()))));
        $form->handleRequest($request);
        /*
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $this->getDoctrine()->getManager()->flush();
                    return $this->redirectToRoute('persone_edit', array('id' => $persone->getId()));
                }
        */
//      Sostituzione lez n 6 del 14/7/2017
/*
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush($persone);
            return $this->redirect($this->generateUrl('persone_index'));
        }
*/
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // @var $em \Doctrine\ORM\EntityManager
                $em = $this->getDoctrine()->getManager();
                $em->flush($persone);
                // mio esercizio sui log
                $this->get('log_example_test')->log('Modificata l\'anagrafica '.$persone->getCodiceFiscale());
                // qui, al contrario della deleteAction, serve perché altrimenti mi riporta sull'edit invece che sulla index
                // potrei provare cambiare il function.js in modo simile alla confirmAction ma adesso non ho tempo (vedremo poi se lo trovo)
                return $this->redirect($this->generateUrl('persone_index'));
            } else {
                return new Response(
                    $this->renderView('AppBundle:persone:edit.html.twig', array(
                        'persone' => $persone,
                        'form' => $form->createView()
                    ))
                    , 409);
            }
        }
//      return $this->render('@App/persone/edit.html.twig', array('persone' => $persone,'edit_form' => $editForm->createView(),'delete_form' => $deleteForm->createView(),));
        return $this->render('@App/persone/edit.html.twig', array('persone' => $persone,'form' => $form->createView(), ));
    }

    /**
     * Deletes a persone entity.
     * Esercizio ripristino delete record del 27/3/2017: cambiata route aggiungendo /delete dopo l'id altrimenti chiamerebbe la show e aggiunto a Method("DELETE") anche GET
     * arrobaRoute("/{id}", name="persone_delete", options={"expose"=true})
     * @Route("/{id}/delete", name="persone_delete", options={"expose"=true})
     * @Method({"GET","DELETE"})
     */
//    public function deleteAction(Request $request, Persone $persone)
//    {
//        // Mio esercizio del 27/3/2017
//        $form = $this->createDeleteForm($persone);
//        //$form = $this->createDeleteForm($persone,array('action' => $this->generateUrl('persone_delete',array('id'=>$persone->getId()))));
//
//        // Mio esercizio del 27/3/2017
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($persone);
//            $em->flush($persone);
//            // mio esercizio sui log
//            $this->get('log_example_test')->log('Cancellata l\'anagrafica '.$persone->getCodiceFiscale());
//            //mio esercizio su delete del 27/03/2017
//            return $this->redirect($this->generateUrl('persone_index'));
//        }
//
//        //return $this->redirectToRoute('persone_index');
//        // Mio esercizio del 27/3/2017
//        return $this->render('@App/persone/delete.html.twig', array('persone' => $persone,'delete_form' => $form->createView(),));
//        //return $this->render('@App/persone/delete.html.twig', array('persone' => $persone,'form' => $form->createView(), ));
//    }
// Esercizio ripristino delete record del 28/3/2017 con Licari
    public function deleteAction(Request $request, Persone $persone)
    {
        // Mio esercizio rivisto a lezione del 28/3/2017
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'DELETE') {
            $em->remove($persone);
            $em->flush();
            // mio esercizio sui log
            $this->get('log_example_test')->log('Cancellata l\'anagrafica del CF '.$persone->getCodiceFiscale());
            // La seguente è inutile perché fa tutto la funzione loadShowIntoPanel() presente in function.js
            // return $this->redirect($this->generateUrl('persone_index'));
            //return $this->indexAction();
        }
        return $this->render('@App/persone/delete.html.twig', array('persone' => $persone,));
    }

    /**
     * Creates a form to delete a persone entity.
     *
     * @param Persone $persone The persone entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
// Dopo l'esercizio di ripristino delete record del 28/3/2017 con Licari la parte che segue non serve più
//    private function createDeleteForm(Persone $persone)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('persone_delete', array('id' => $persone->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//            ;
//    }


}