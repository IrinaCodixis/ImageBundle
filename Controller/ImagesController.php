<?php

namespace Mipa\ImageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mipa\ImageBundle\Entity\Images;
use Mipa\ImageBundle\Form\ImagesType;

/**
 * Images controller.
 *
 */
class ImagesController extends Controller
{

    /**
     * Lists all Images entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MipaImageBundle:Images')->findAll();

        return $this->render('MipaImageBundle:Images:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Images entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Images();
        $request = $this->getRequest();
		$form    = $this->createForm(new ImagesType(), $entity);
		$form->bind($request);
        
		if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
						
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mipa_img_preview', array('id' => $entity->getId())));
        }

        return $this->render('MipaImageBundle:Images:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Images entity.
     *
     * @param Images $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Images $entity)
    {
        $form = $this->createForm(new ImagesType(), $entity, array(
            'action' => $this->generateUrl('mipa_img_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Images entity.
     *
     */
    public function newAction()
    {
        $entity = new Images();
        $form   = $this->createForm(new ImagesType(), $entity);

        return $this->render('MipaImageBundle:Images:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Images entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MipaImageBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MipaImageBundle:Images:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Images entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MipaImageBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MipaImageBundle:Images:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Images entity.
    *
    * @param Images $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Images $entity)
    {
        $form = $this->createForm(new ImagesType(), $entity, array(
            'action' => $this->generateUrl('mipa_img_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Images entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MipaImageBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mipa_img_preview', array('id' => $id)));
        }

        return $this->render('MipaImageBundle:Images:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Images entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MipaImageBundle:Images')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Images entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mipa_img'));
    }

    /**
     * Creates a form to delete a Images entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mipa_img_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	public function previewAction($id)
	{
	  $em = $this->getDoctrine()->getManager();
	 
	  $entity = $em->getRepository('MipaImageBundle:Images')->find($id);
	 
	  if (!$entity) {
		throw $this->createNotFoundException('Unable to find entity.');
	  }
	 
		 $deleteForm = $this->createDeleteForm($entity->getId());
 
	  return $this->render('MipaImageBundle:Images:show.html.twig', array(
		'entity'      => $entity,
		'delete_form' => $deleteForm->createView(),
	  ));
	}
	
	
}
