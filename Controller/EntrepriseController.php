<?php

namespace NomayaCandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NomayaCandidaturesBundle\Entity\Entreprise;
use NomayaCandidaturesBundle\Form\EntrepriseType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Entreprise controller.
 *
 * @Route("/entreprise")
 */
class EntrepriseController extends Controller
{

    /**
     * Lists all Entreprise entities.
     *
     * @Route("/", name="entreprise")
     * @Route("/order/{column}/{direction}", name="entreprise_ordered", defaults={ "column" = "id" , "direction" = "ASC" } )
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request, $column = null, $direction = null)
    {
        $em = $this->getDoctrine()->getManager();

        $search =  $request->get('search');
        $search = is_null($search) ? null : trim($search);


        $entities = $em
                        ->getRepository('CandidaturesBundle:Entreprise')
                        ->findAllOrderedBy($column, $direction, $search);

        $result = array('entities' => $entities);
        if (!is_null($search))
            $result['search'] = $search;
        return $result;
    }
    /**
     * Creates a new Entreprise entity.
     *
     * @Route("/create", name="entreprise_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new Entreprise();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($request->isXmlHttpRequest()){
                $response = new \stdClass();
                $response->option = $this->renderView('CandidaturesBundle:Entreprise:select_option.html.twig', array('entreprise' => $entity));
                return new JsonResponse($response);
            }

            return $this->redirect($this->generateUrl('entreprise_show', array('id' => $entity->getId())));
        }

        return $this->render('CandidaturesBundle:Entreprise:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Entreprise entity.
     *
     * @param Entreprise $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entreprise $entity)
    {
        $form = $this->createForm(new EntrepriseType(), $entity, array(
            'action' => $this->generateUrl('entreprise_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entreprise entity.
     *
     * @Route("/new", name="entreprise_new")
     * @Method("GET")
     */
    public function newAction($ajax = false)
    {
        $entity = new Entreprise();
        $request = Request::createFromGlobals();
        $form   = $this->createCreateForm($entity);

        if ($ajax || $request->isXmlHttpRequest()){
            return $this->render('CandidaturesBundle:Entreprise:form_new.html.twig',array(
                'form'   => $form->createView(),
            ));
        }
        return $this->render('CandidaturesBundle:Entreprise:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Entreprise entity.
     *
     * @Route("/{id}", name="entreprise_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        //$entity = $em->getRepository('CandidaturesBundle:Entreprise')->find($id);
        $entity = $em->getRepository('CandidaturesBundle:Entreprise')->findOneWithCandidatures($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entreprise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Entreprise entity.
     *
     * @Route("/{id}/edit", name="entreprise_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Entreprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entreprise entity.');
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
    * Creates a form to edit a Entreprise entity.
    *
    * @param Entreprise $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entreprise $entity)
    {
        $form = $this->createForm(new EntrepriseType(), $entity, array(
            'action' => $this->generateUrl('entreprise_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entreprise entity.
     *
     * @Route("/{id}", name="entreprise_update")
     * @Method("PUT")
     * @Template("CandidaturesBundle:Entreprise:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Entreprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entreprise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entreprise'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Entreprise entity.
     *
     * @Route("/{id}", name="entreprise_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:Entreprise')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entreprise entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entreprise'));
    }

    /**
     * Creates a form to delete a Entreprise entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entreprise_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
