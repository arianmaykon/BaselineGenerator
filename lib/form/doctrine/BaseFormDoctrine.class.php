<?php

/**
 * Project form base class.
 *
 * @package    baselinegenerator
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  public function setup()
  {
        $this->offsetUnset('created_at');
        $this->offsetUnset('updated_at');
        $this->offsetUnset('created_by');
        $this->offsetUnset('updated_by');  	
  }
}
