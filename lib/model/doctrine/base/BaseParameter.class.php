<?php

/**
 * BaseParameter
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $jiraBaseUrl
 * @property string $svnBaseUrl
 * @property string $ftpHost
 * @property string $ftpUser
 * @property string $ftpPassword
 * @property integer $ftpPort
 * @property string $testBaselineMailBody
 * @property string $releaseBaselineMailBody
 * @property string $availabilityMailBody
 * 
 * @method string    getJiraBaseUrl()             Returns the current record's "jiraBaseUrl" value
 * @method string    getSvnBaseUrl()              Returns the current record's "svnBaseUrl" value
 * @method string    getFtpHost()                 Returns the current record's "ftpHost" value
 * @method string    getFtpUser()                 Returns the current record's "ftpUser" value
 * @method string    getFtpPassword()             Returns the current record's "ftpPassword" value
 * @method integer   getFtpPort()                 Returns the current record's "ftpPort" value
 * @method string    getTestBaselineMailBody()    Returns the current record's "testBaselineMailBody" value
 * @method string    getReleaseBaselineMailBody() Returns the current record's "releaseBaselineMailBody" value
 * @method string    getAvailabilityMailBody()    Returns the current record's "availabilityMailBody" value
 * @method Parameter setJiraBaseUrl()             Sets the current record's "jiraBaseUrl" value
 * @method Parameter setSvnBaseUrl()              Sets the current record's "svnBaseUrl" value
 * @method Parameter setFtpHost()                 Sets the current record's "ftpHost" value
 * @method Parameter setFtpUser()                 Sets the current record's "ftpUser" value
 * @method Parameter setFtpPassword()             Sets the current record's "ftpPassword" value
 * @method Parameter setFtpPort()                 Sets the current record's "ftpPort" value
 * @method Parameter setTestBaselineMailBody()    Sets the current record's "testBaselineMailBody" value
 * @method Parameter setReleaseBaselineMailBody() Sets the current record's "releaseBaselineMailBody" value
 * @method Parameter setAvailabilityMailBody()    Sets the current record's "availabilityMailBody" value
 * 
 * @package    baselinegenerator
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseParameter extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('parameter');
        $this->hasColumn('jiraBaseUrl', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('svnBaseUrl', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('ftpHost', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ftpUser', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ftpPassword', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ftpPort', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('testBaselineMailBody', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('releaseBaselineMailBody', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('availabilityMailBody', 'string', null, array(
             'type' => 'string',
             ));

        $this->option('symfony', array(
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzBlameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}