<?php

namespace NomayaCandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NomayaCandidaturesBundle\Entity\Candidature;
use NomayaCandidaturesBundle\Form\CandidatureType;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Candidature controller.
 *
 * @Route("/candidature")
 */
class CandidatureController extends Controller
{

    /**
     * Lists all Candidature entities.
     *
     * @Route("/", name="candidature")
     * @Route("/order/{column}/{direction}", name="candidature_ordered", defaults={ "column" = "dateOffre" , "direction" = "ASC" } )
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request, $column = null, $direction = null)
    {
        $em = $this->getDoctrine()->getManager();

        $search =  $request->get('search');
        $search = is_null($search) ? null : trim($search);

        if (is_null($column))
        {
            $entities = $em
                            ->getRepository('CandidaturesBundle:Candidature')
                            ->findAllOrderedByUpdatedAtDate($search);
        } else
        {
            $entities = $em
                            ->getRepository('CandidaturesBundle:Candidature')
                            ->findAllOrderedBy($column, $direction, $search);
        }

        $result = array('entities' => $entities);
        if (!is_null($search))
            $result['search'] = $search;
        return $result;
    }

    /**
     * Creates a new Candidature entity.
     *
     * @Route("/create", name="candidature_create")
     * @Method("POST")
     * @Template("CandidaturesBundle:Candidature:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Candidature();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('candidature_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Candidature entity.
     *
     * @param Candidature $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Candidature $entity)
    {
        $form = $this->createForm(new CandidatureType(), $entity, array(
            'action' => $this->generateUrl('candidature_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Candidature entity.
     *
     * @Route("/new", name="candidature_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Candidature();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Candidature entity.
     *
     * @Route("/{id}", name="candidature_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Candidature')->findOneWithRelated($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidature entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Candidature entity.
     *
     * @Route("/{id}/edit", name="candidature_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Candidature')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidature entity.');
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
    * Creates a form to edit a Candidature entity.
    *
    * @param Candidature $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Candidature $entity)
    {
        $form = $this->createForm(new CandidatureType(), $entity, array(
            'action' => $this->generateUrl('candidature_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Candidature entity. Sets its status to true / false (success / failure)
     * redirects to the $route page with $routeParams
     *
     * @Route("/{id}/status/{status}/show/{show}", name="candidature_update_status", defaults={ "status" = "success", "show" = 0})
     * @Method("GET")
     */
    public function updateStatusAction(Request $request, $id, $status, $show = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Candidature')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidature entity.');
        }
        
        $entity->setStatus($status === 'success');

        $em->persist($entity);
        $em->flush();

        if ($show){
            $route = 'candidature_show';
            $routeParams = array('id' => $id);
        } else {
            $route = 'candidature';
            $routeParams = array();            
        }
            
        return $this->redirect($this->generateUrl($route, $routeParams));
    }

    /**
     * Edits an existing Candidature entity.
     *
     * @Route("/{id}", name="candidature_update")
     * @Method("PUT")
     * @Template("CandidaturesBundle:Candidature:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Candidature')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Candidature entity.');
        }

        // les documents liés sont mis dans un tableau
        $originalDocuments = new ArrayCollection();

        // Crée un tableau contenant les objets Document courants de la
        // base de données
        foreach ($entity->getDocuments() as $document) {
            $originalDocuments->add($document);
        }


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            // supprime la relation entre le document et la « Candidature »
            foreach ($originalDocuments as $document) {
                if ($entity->getDocuments()->contains($document) == false) {
                // supprime la « Candidature » du Document
                    $entity->getDocuments()->removeElement($document);

                    $em->persist($document);

                    // si vous souhaitiez supprimer totalement le Document, vous pourriez
                    // aussi faire comme cela
                    $em->remove($document);
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('candidature'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Candidature entity.
     *
     * @Route("/{id}", name="candidature_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:Candidature')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Candidature entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('candidature'));
    }

    /**
     * Creates a form to delete a Candidature entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('candidature_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
