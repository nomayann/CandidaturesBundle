<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nomaya\Candidatures\CandidaturesBundle\Entity\Document;
use Nomaya\Candidatures\CandidaturesBundle\Form\DocumentType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{

    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CandidaturesBundle:Document')->findAllWithRelated();
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
     * Creates a new Document entity.
     *
     * @Route("/", name="document_upload")
     * @Method("POST")
     */
    public function uploadAction(Request $request)
    {
        /* Ce contrôleur peut fonctionner avec ou sans ajax
        * Si c'est ajax, il renvoie une réponse 200 et le lien vers le document ajouté
        * sinon, renvoie vers l'affichage du document
        */
        $entity = new Document();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($request->isXmlHttpRequest()){
                $response = new \stdClass();
                $response->document = $this->renderView('CandidaturesBundle:Document:download_link.html.twig', array('document' => $entity));
                return new JsonResponse($response);
            }

            return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
        }
        // Affichage du formulaire
         return $this->render("CandidaturesBundle:Document:new.html.twig", array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_upload'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="document_new")
     * @Method("GET")
     */
    public function newAction($ajax = false, $params = null)
    {
        $entity = new Document();

        if ($params && is_array($params)){
            $em = $this->getDoctrine()->getManager();
            if (array_key_exists('candidature_id', $params)){
                $candidature = $em->getRepository('CandidaturesBundle:Candidature')->find($params['candidature_id']);
                $entity->setCandidature($candidature);
            }
            if (array_key_exists('evenement_id', $params)){
                $evenement = $em->getRepository('CandidaturesBundle:Evenement')->find($params['evenement_id']);
                $entity->setCandidature($evenement);
            }
        }
        $form   = $this->createCreateForm($entity);

        if ($ajax){
            return $this->render('CandidaturesBundle:Document:form.html.twig',array(
                'form'   => $form->createView(),
            ));
        }
        return $this->render('CandidaturesBundle:Document:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}", name="document_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CandidaturesBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CandidaturesBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('document'));
    }

    /**
     * Creates a form to delete a Document entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

}
