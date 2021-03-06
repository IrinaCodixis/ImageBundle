<?php
namespace Mipa\ImageBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Mipa\ImageBundle\Entity\Images;
 
class ImageAdmin extends Admin
{
	
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
			->add('name')
			->add('file', 'file', array('label' => 'Pictures', 'required' => false))
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
			->add('name')
			;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('title')
			->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
 
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
			->add('name')
			->add('webPath', 'string', array('template' => 'MipaImageBundle:ImageAdmin:list_image.html.twig'))
        ;
    }
	
	public function getBatchActions()
	{
		// retrieve the default (currently only the delete action) actions
		$actions = parent::getBatchActions();
	 
		// check user permissions
		if($this->hasRoute('edit') && $this->isGranted('EDIT') && $this->hasRoute('delete') && $this->isGranted('DELETE')) {
			$actions['extend'] = array(
				'label'            => 'Extend',
				'ask_confirmation' => true // If true, a confirmation will be asked before performing the action
			);
	 
		}
	 
		return $actions;
	}
}

?>