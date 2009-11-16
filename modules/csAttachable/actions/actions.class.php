<?php

/**
 * csAttachable actions.
 *
 * @package    csDoctrineActAsAttachablePlugin
 * @subpackage csAttachable
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class csAttachableActions extends sfActions
{
  public function preExecute()
  {
    $this->table = $this->getRequestParameter('table');
    parent::preExecute();
  }
  public function executeAttachmentSave(sfWebRequest $request)
  {
    $files = $request->getFiles('attachment');
    $this->setTemplate('iframe');
    if($this->isUpload($files))
    {
      if(!$this->isEmptyFile($files))
      {
        $this->bindAttachment($request->getParameter('attachment'), $files);
        if($this->form->isValid())
        {
          $this->form->save();
        }
        else
        {
          $errors = $this->form->getErrorList();
          $this->alert = implode("\n", $errors);
        }   
      }
      else
      {
        $this->alert = 'Please select a file to upload';
      }
    }
    else
    {
      $this->bindExternalUrl($request);
      if($this->form->isValid())
      {
        $this->form->save();
      }
      else
      {
        $errors = $this->form->getErrorList();
        $this->alert = 'Errors on: '.implode(", ", array_keys($errors)) .': '. implode("\n", $errors);
      } 
    }
  }

  public function executeAttachmentRefresh(sfWebRequest $request)
  {
    $this->refreshObject();
    return $this->renderComponent('csAttachable', 'attachments', array('object' => $this->object, 'table' => $this->table, 'javascriptHelper' => $this->javascriptHelper));    
  }
  
  public function executeAttachmentDelete(sfWebRequest $request)
  {
    $attachment = Doctrine::getTable('Attachment')->findOneById($this->getRequestParameter('attachment_id'));
    $attachment->delete();
    $dir = 'uploads/'.strtolower($this->table).'/'.$attachment->getUrl();
    if(file_exists($dir))
    {
      unlink($dir);
    }
    $this->refreshObject();
    return $this->renderComponent('csAttachable', 'attachments', array('object' => $this->object, 'table' => $this->table, 'javascriptHelper' => $request->getParameter('javascriptHelper', 'Javascript')));
  }
  
  public function bindExternalUrl($request)
  {
    $this->object = $this->getAttachableObject();

    $attachment = $this->getNewAttachmentModel();
    $this->form = $this->getNewAttachmentForm($attachment, $this->object);
    $vars = $request->getParameter('attachment');

    $this->form->bind($request->getParameter('attachment'));
  }
  
  public function bindAttachment($values, $files)
  {
    $this->object = $this->getAttachableObject();

    $attachment = $this->getNewAttachmentModel();
    $this->form = $this->getNewAttachmentForm($attachment, $this->object);

    $values['title'] = $this->getFileName($files);
    $this->form->bind($values, $files);
    return $this->form;
  }
  
  public function getAttachableObject()
  {
    return Doctrine::getTable($this->table)->findOneById($this->getRequestParameter('object_id'));
  }
  
  public function getNewAttachmentForm($attachment, $object)
  {
    $type = $this->getRequestParameter('attachment_type');
    $form = strtolower($type) == 'other' ? 'AttachmentForm' : $type.'AttachmentForm';
    return new $form($attachment, $object);
  }
  
  public function getNewAttachmentModel()
  {
    $type = $this->getRequestParameter('attachment_type');
    $model = strtolower($type) == 'other' ? 'Attachment' : $type.'Attachment';
    return new $model();
  }
  
  public function getFileName($file)
  {
    if(isset($file['url']['name']))
    {
      return $file['url']['name'];
    }
    else
    {
      return $file['name']['url'];
    }
  }
  
  public function isEmptyFile($file)
  {
    if((isset($file['url']['name']) && $file['url']['name']) || (isset($file['name']['url']) && $file['name']['url']))
    {
      return false;
    }
    return true;
  }
  
  public function refreshObject()
  {
    $this->object = Doctrine::getTable($this->table)->findOneById($this->getRequestParameter('object_id'));
    $newForm = $this->table.'Form';
    $this->form = new $newForm($this->object);
    $this->javascriptHelper = $this->getRequest()->getParameter('javascriptHelper', 'Javascript');
    unset($this->form['description']);
  }
  
  public function getEmptyAttachmentArray()
  {
    return array();
    return array('attachment' => false);
  }
  
  public function isUpload($files)
  {
    if($files)
    {
      return true;
    }
    return false;
  }
}
