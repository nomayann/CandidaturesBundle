<?php

namespace NomayaCandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NomayaCandidaturesBundle\Entity\Contact;
use NomayaCandidaturesBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="contact")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $search = $request->get('search');
        $search = is_null($search) ? null : trim($search);

        $em = $this->getDoctrine()->getManager();

        $entities = $em
                        ->getRepository('CandidaturesBundle:Contact')
                        ->findAllWithRelated($search);

        $result = array('entities' => $entities);
        if (!is_null($search))
            $result['search'] = $search;
        return $result;
    }


    /**
     * Creates a new Contact entity.
     *
     * @Route("/create", name="contact_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new Contact();
        $request = Request::createFromGlobals();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($request->isXmlHttpRequest()){
                return new JsonResponse('succes');
            }

            return $this->redirect($this->generateUrl('contact_show', array('id' => $entity->getId())));
        }

        return $this->render("CandidaturesBundle:Contact:new.html.twig", array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Contact entity.
     *
     * @param Contact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Contact $entity, array $options = array())
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ContactType($manager, $options), $entity, array(
            'action' => $this->generateUrl('contact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Route("/new/entreprise/{entreprise_id}", name="contact_new_in_entreprise")
     * @Method("GET")
     * @Template()
     */
    public function newAction($ajax = false, $entreprise_id = null)
    {
        $entity = new Contact();
        $request = Request::createFromGlobals();
        $options = array();

        if (!is_null($entreprise_id)){
            $em = $this->getDoctrine()->getManager();
            $entreprise = $em->getRepository('CandidaturesBundle:Entreprise')->find($entreprise_id);
            $entity->setEntreprise($entreprise);
            $options = array('entreprise' => 'hide');
        }

        $form   = $this->createCreateForm($entity, $options);

        if ($ajax || $request->isXmlHttpRequest()){
            return $this->render('CandidaturesBundle:Contact:form_new.html.twig',array(
                'form'   => $form->createView(),
            ));
        }
        return $this->render('CandidaturesBundle:Contact:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Contact entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contact $entity)
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ContactType($manager), $entity, array(
            'action' => $this->generateUrl('contact_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Valider'));

        return $form;
    }
    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}", name="contact_update")
     * @Method("PUT")
     * @Template("CandidaturesBundle:Contact:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contact'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}", name="contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contact'));
    }

    /**
     * Creates a form to delete a Contact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
