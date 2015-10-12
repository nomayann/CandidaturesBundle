<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nomaya\Candidatures\CandidaturesBundle\Entity\TypeCandidature;
use Nomaya\Candidatures\CandidaturesBundle\Form\TypeCandidatureType;

/**
 * TypeCandidature controller.
 *
 * @Route("/typecandidature")
 */
class TypeCandidatureController extends Controller
{

    /**
     * Lists all TypeCandidature entities.
     *
     * @Route("/", name="typecandidature")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CandidaturesBundle:TypeCandidature')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TypeCandidature entity.
     *
     * @Route("/", name="typecandidature_create")
     * @Method("POST")
     * @Template("CandidaturesBundle:TypeCandidature:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TypeCandidature();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typecandidature_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TypeCandidature entity.
     *
     * @param TypeCandidature $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeCandidature $entity)
    {
        $form = $this->createForm(new TypeCandidatureType(), $entity, array(
            'action' => $this->generateUrl('typecandidature_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeCandidature entity.
     *
     * @Route("/new", name="typecandidature_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TypeCandidature();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TypeCandidature entity.
     *
     * @Route("/{id}", name="typecandidature_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:TypeCandidature')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeCandidature entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TypeCandidature entity.
     *
     * @Route("/{id}/edit", name="typecandidature_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:TypeCandidature')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeCandidature entity.');
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
    * Creates a form to edit a TypeCandidature entity.
    *
    * @param TypeCandidature $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeCandidature $entity)
    {
        $form = $this->createForm(new TypeCandidatureType(), $entity, array(
            'action' => $this->generateUrl('typecandidature_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TypeCandidature entity.
     *
     * @Route("/{id}", name="typecandidature_update")
     * @Method("PUT")
     * @Template("CandidaturesBundle:TypeCandidature:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:TypeCandidature')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeCandidature entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typecandidature_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TypeCandidature entity.
     *
     * @Route("/{id}", name="typecandidature_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:TypeCandidature')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeCandidature entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('typecandidature'));
    }

    /**
     * Creates a form to delete a TypeCandidature entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typecandidature_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
