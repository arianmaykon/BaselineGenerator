<?php

/**
 * baseline actions.
 *
 * @package    baselinegenerator
 * @subpackage baseline
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class baselineActions extends sfActions
{
  public function executeGenerate(sfWebRequest $request)
  {
    $this->forward404('Not implemented');
/*
#    $this->form = new BaselineForm();
    $this->forward404Unless($baseline = Doctrine_Core::getTable('Baseline')->find(array($request->getParameter('id'))), sprintf('Object baseline does not exist (%s).', $request->getParameter('id')));
    $baseline;

    $success = true;

    try {
*/
/*
      # http://brentertainment.com/2010/02/15/run-a-symfony-task-from-your-model-or-action/
      chdir(sfConfig::get('sf_root_dir')); // Trick plugin into thinking you are in a project directory
      $task = new generatebaselineTask($this->getContext()->getEventDispatcher(), new sfFormatter());
#      $task->run(array('baseline_id' => $baseline->getId()), array('option_name' => 'option'));
      $result = $task->run(array('baseline_id' => $baseline->getId()));
*/
#-------------------------------------------------------------------------------
/*
        $bp = new BaselineProcess($baseline);
        $bp->execute();
    } catch(Exception $e) {
      $success = false;

      $this->getLogger()->err($e->getMessage());
      $this->forward404('Não foi possível gerar a baseline.');
    }

    $this->success = $success;
*/
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->baselines = Doctrine_Core::getTable('Baseline')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new BaselineForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new BaselineForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($baseline = Doctrine_Core::getTable('Baseline')->find(array($request->getParameter('id'))), sprintf('Object baseline does not exist (%s).', $request->getParameter('id')));
    $this->form = new BaselineForm($baseline);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($baseline = Doctrine_Core::getTable('Baseline')->find(array($request->getParameter('id'))), sprintf('Object baseline does not exist (%s).', $request->getParameter('id')));
    $this->form = new BaselineForm($baseline);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($baseline = Doctrine_Core::getTable('Baseline')->find(array($request->getParameter('id'))), sprintf('Object baseline does not exist (%s).', $request->getParameter('id')));
    $baseline->delete();

    $this->redirect('baseline/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $baseline = $form->save();

      $this->redirect('baseline/edit?id='.$baseline->getId());
    }
  }
}
