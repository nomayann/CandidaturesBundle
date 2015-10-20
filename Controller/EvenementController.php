<?php

namespace NomayaCandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NomayaCandidaturesBundle\Entity\Evenement;
use NomayaCandidaturesBundle\Form\EvenementType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Evenement controller.
 *
 * @Route("/evenement")
 */
class EvenementController extends Controller
{

    /**
     * Lists all Evenement entities.
     *
     * @Route("/", name="evenement")
     * @Route("/order/{column}/{direction}", name="evenement_ordered", defaults={ "column" = "date" , "direction" = "DESC" } )
     * @Route("/todo/{todo}/{column}/{direction}", name="evenement_todo", defaults={ "todo" = "true" , "column" = "date" , "direction" = "DESC" } )
     * @Method("GET")
     * @Template()
     */
    public function indexAction($column = null, $direction = null, $todo = null)
    {
        $em = $this->getDoctrine()->getManager();

        $column = is_null($column)? 'date' : $column;
        $direction = is_null($direction)? 'DESC' : $direction;
        $start = 0;
        $limit = 0;
        $linkCandidature = false;
        
        $entities = $em->getRepository('CandidaturesBundle:Evenement')->findAllOrderedBy($column, $direction, $start, $limit, $linkCandidature, $todo);
        
        // Ajout du formulaire de suppression à chaque entité
        foreach ($entities as &$entity){
            $deleteForm = $this->createDeleteForm($entity->getId());
            $entity->deleteForm = $deleteForm->createView();
        }

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Evenement entity.
     *
     * @Route("/", name="evenement_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        /* Ce contrôleur peut fonctionner avec ou sans ajax
        * Si c'est ajax, il renvoie une réponse 200 et le lien vers le document ajouté
        * sinon, renvoie vers l'affichage du document
        */
        $entity = new Evenement();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($request->isXmlHttpRequest()){
                $response = new \stdClass();    
                $response->evenement = $this->renderView('CandidaturesBundle:Evenement:list_elt.html.twig', array('evenement' => $entity));
                return new JsonResponse($response);
            }

            return $this->redirect($this->generateUrl('evenement_show', array('id' => $entity->getId())));
        }

        return $this->render('CandidaturesBundle:Evenement:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Evenement entity.
     *
     * @param Evenement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Evenement $entity, array $options = array())
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new EvenementType($manager, $options), $entity, array(
            'action' => $this->generateUrl('evenement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Evenement entity.
     *
     * @Route("/new", name="evenement_new")
     * @Route("/new/{candidature_id}/{ajax}", name="evenement_new_2", defaults={"candidature_id" = null ,"ajax" = 0})
     * @Method("GET")
     */
    public function newAction($candidature_id = null, $ajax = 0)
    {
        $entity = new Evenement();
        $request = Request::createFromGlobals();
        $options = array();

        if ( !is_null($candidature_id) ){
            $em = $this->getDoctrine()->getManager();
            $candidature = $em->getRepository('CandidaturesBundle:Candidature')->find($candidature_id);
            $entity->setCandidature($candidature);
            $options['candidature'] = 'hide';
        }

        $form   = $this->createCreateForm($entity, $options);

        if ($ajax || $request->isXmlHttpRequest()){
            return $this->render('CandidaturesBundle:Evenement:form_new.html.twig',array(
                'form'   => $form->createView(),
                'ajax' => true
            ));
        }
        return $this->render('CandidaturesBundle:Evenement:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'ajax'  => false
        ));

    }

    /**
     * Finds and displays a Evenement entity.
     *
     * @Route("/{id}", name="evenement_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Evenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evenement entity.');
        }
        if ($this->getRequest()->isXmlHttpRequest()) {
                return $this->render('CandidaturesBundle:Evenement:show_modal.html.twig', array('entity' => $entity));        
        } else {
            $deleteForm = $this->createDeleteForm($id);

            return array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
            );
        }
    }

    /**
     * Displays a form to edit an existing Evenement entity.
     *
     * @Route("/{id}/edit/{ajax}", name="evenement_edit", defaults={"ajax" = 0})
     * @Method("GET")
     */
    public function editAction($id, $ajax = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();

        $entity = $em->getRepository('CandidaturesBundle:Evenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evenement entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        if ($ajax || $request->isXmlHttpRequest()){
            return $this->render('CandidaturesBundle:Evenement:form_edit.html.twig',array(
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'ajax' => true
            ));
        }
        return $this->render('CandidaturesBundle:Evenement:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ajax' => false
        ));

    }

    /**
    * Creates a form to edit a Evenement entity.
    *
    * @param Evenement $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Evenement $entity)
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new EvenementType($manager, array('candidature' => 'hide')), $entity, array(
            'action' => $this->generateUrl('evenement_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    /**
     * Edits an existing Evenement entity.
     *
     * @Route("/{id}", name="evenement_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Evenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evenement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            if ($request->isXmlHttpRequest()){
                $response = new \stdClass();
                $response->evenement = $this->renderView('CandidaturesBundle:Evenement:list_elt.html.twig', array('evenement' => $entity));
                return new JsonResponse($response);
            }

            return $this->redirect($this->generateUrl('evenement_edit', array('id' => $id)));
        }

        return $this->render("CandidaturesBundle:Evenement:edit.html.twig", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Evenement entity.
     *
     * @Route("/{id}", name="evenement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:Evenement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evenement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('evenement'));
    }

    /**
     * Creates a form to delete a Evenement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
