<?php

/**
 * system actions.
 *
 * @package    baselinegenerator
 * @subpackage system
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class systemActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->systems = Doctrine_Core::getTable('System')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SystemForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SystemForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($system = Doctrine_Core::getTable('System')->find(array($request->getParameter('id'))), sprintf('Object system does not exist (%s).', $request->getParameter('id')));
    $this->form = new SystemForm($system);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($system = Doctrine_Core::getTable('System')->find(array($request->getParameter('id'))), sprintf('Object system does not exist (%s).', $request->getParameter('id')));
    $this->form = new SystemForm($system);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($system = Doctrine_Core::getTable('System')->find(array($request->getParameter('id'))), sprintf('Object system does not exist (%s).', $request->getParameter('id')));
    $system->delete();

    $this->redirect('system/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $system = $form->save();

      $this->redirect('system/edit?id='.$system->getId());
    }
  }
}
