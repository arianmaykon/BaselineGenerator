<?php

class generatebaselineTask extends sfBaseTask {

    protected function configure() {
        // // add your own arguments here
        $this->addArguments(array(
            new sfCommandArgument('baseline_id', sfCommandArgument::REQUIRED, 'ID da baseline a ser gerada.'),
        ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env'        , null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection' , null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace = '';
        $this->name = 'generatebaseline';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [generatebaseline|INFO] task does things.
Call it with:

  [php symfony generatebaseline|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {

        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        $baselineTable = BaselineTable::getInstance();
        $baseline = $baselineTable->find($arguments['baseline_id']);

        if (!$baseline) {
            throw new Exception('Baseline não encontrada.');
            exit;
        }
#error_reporting(E_PARSE | E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR | E_USER_ERROR);
        $bp = new BaselineProcess($baseline);
        $result = $bp->execute();

        foreach ($result as $key => $value) {
            if (is_array($value) && strcasecmp($key, $baseline->getType()) == 0) {
                foreach ($value as $key1 => $value1) {
                    if (!$value1) {
                        $this->log('TODO: ' . $key1);
                    }
                }
            } else if (!$value) {
                $this->log('TODO: ' . $key);
            }
        }
    }
}