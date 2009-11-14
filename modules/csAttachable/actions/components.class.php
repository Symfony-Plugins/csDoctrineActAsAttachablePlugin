<?php

/**
 * widgets actions.
 *
 * @package    sarp
 * @subpackage widgets
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class csAttachableComponents extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
	public function executeAttachments()
	{
		//Get New Attachment Form
		$object = $this->form ? $this->form->getObject() : $this->object;
		$this->table = isset($this->table) ? $this->table : get_class($this->form->getObject());
		$this->types = $object->getSupportedAttachmentTypes();
		// $this->types = array();
		if($this->types)
		{
			foreach ($this->types as $type) 
			{
				$this->setAttachmentType($type, $object);
			}
		}
		else
		{
			$this->attachment = new AttachmentForm(null, $object);
			// $this->attachment->setObjectClass($this->table);
			// $this->attachment->setObjectId($this->form->getObject()->getId());
			unset($this->attachment['id']);
			//If the object is set, get the attachment forms for the object
			if($object)
			{
				// $object = Doctrine::getTable($this->table)->findOneById($this->objectId);
				$this->attachments = new BackendAttachmentsForm(array(), array('attachments' => $object->getAttachments()));
			}	
		}
		if($object)
		{
			$newForm = $this->table.'Form';
			$this->form = new $newForm($object);
		}	
	}
	public function setAttachmentType($type, $object)
	{
		$prefix = strtolower($type) == 'other' ? '' : $type;
		$form_class = $prefix . 'AttachmentForm';
		$table_name = $prefix .'AttachmentTable'; 
		$type_form = $type.'_form';
		$form = new $form_class(null, $object);
		unset($form['id']);
		$this->$type_form = $form;
		
		//If the object is set, get the attachment forms for the object
		if($object)
		{
			// $object = Doctrine::getTable($this->table)->findOneById($this->objectId);
			$this->$type = new BackendAttachmentsForm($object->getAttachmentsByType($type));
		}

	}
	public function executeAttachments_group()
	{
		//Get New Attachment Form
		// $object = $this->form ? $this->form->getObject() : $this->object;
		// $this->attachment = new AttachmentForm(null, $object);
		// $this->table = isset($this->table) ? $this->table : get_class($this->form->getObject());
		// // $this->attachment->setObjectClass($this->table);
		// // $this->attachment->setObjectId($this->form->getObject()->getId());
		// unset($this->attachment['id']);
		// //If the object is set, get the attachment forms for the object
		// if($object)
		// {
		// 	// $object = Doctrine::getTable($this->table)->findOneById($this->objectId);
		// 
		// 	$this->attachments = new BackendAttachmentsForm($object->getAttachments());
		// 	
		// 	$newForm = $this->table.'Form';
		// 	$this->form = new $newForm($object);
		// }
	}
	public function executeAttachments_list()
	{
		
	}
}
