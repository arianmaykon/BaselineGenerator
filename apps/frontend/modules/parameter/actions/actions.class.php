<?php

/**
 * parameter actions.
 *
 * @package    baselinegenerator
 * @subpackage parameter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class parameterActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->parameters = Doctrine_Core::getTable('Parameter')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ParameterForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ParameterForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($parameter = Doctrine_Core::getTable('Parameter')->find(array($request->getParameter('id'))), sprintf('Object parameter does not exist (%s).', $request->getParameter('id')));
    $this->form = new ParameterForm($parameter);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($parameter = Doctrine_Core::getTable('Parameter')->find(array($request->getParameter('id'))), sprintf('Object parameter does not exist (%s).', $request->getParameter('id')));
    $this->form = new ParameterForm($parameter);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($parameter = Doctrine_Core::getTable('Parameter')->find(array($request->getParameter('id'))), sprintf('Object parameter does not exist (%s).', $request->getParameter('id')));
    $parameter->delete();

    $this->redirect('parameter/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $parameter = $form->save();

      $this->redirect('parameter/edit?id='.$parameter->getId());
    }
  }
}
