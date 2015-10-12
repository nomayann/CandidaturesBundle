<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nomaya\Candidatures\CandidaturesBundle\Entity\TypeEvenement;
use Nomaya\Candidatures\CandidaturesBundle\Form\TypeEvenementType;

/**
 * TypeEvenement controller.
 *
 * @Route("/typeevenement")
 */
class TypeEvenementController extends Controller
{

    /**
     * Lists all TypeEvenement entities.
     *
     * @Route("/", name="typeevenement")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CandidaturesBundle:TypeEvenement')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TypeEvenement entity.
     *
     * @Route("/", name="typeevenement_create")
     * @Method("POST")
     * @Template("CandidaturesBundle:TypeEvenement:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TypeEvenement();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typeevenement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TypeEvenement entity.
     *
     * @param TypeEvenement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeEvenement $entity)
    {
        $form = $this->createForm(new TypeEvenementType(), $entity, array(
            'action' => $this->generateUrl('typeevenement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeEvenement entity.
     *
     * @Route("/new", name="typeevenement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TypeEvenement();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TypeEvenement entity.
     *
     * @Route("/{id}", name="typeevenement_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:TypeEvenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeEvenement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TypeEvenement entity.
     *
     * @Route("/{id}/edit", name="typeevenement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:TypeEvenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeEvenement entity.');
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
    * Creates a form to edit a TypeEvenement entity.
    *
    * @param TypeEvenement $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeEvenement $entity)
    {
        $form = $this->createForm(new TypeEvenementType(), $entity, array(
            'action' => $this->generateUrl('typeevenement_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TypeEvenement entity.
     *
     * @Route("/{id}", name="typeevenement_update")
     * @Method("PUT")
     * @Template("CandidaturesBundle:TypeEvenement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:TypeEvenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeEvenement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typeevenement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TypeEvenement entity.
     *
     * @Route("/{id}", name="typeevenement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:TypeEvenement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeEvenement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('typeevenement'));
    }

    /**
     * Creates a form to delete a TypeEvenement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeevenement_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
