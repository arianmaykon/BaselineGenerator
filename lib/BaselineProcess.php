<?php

class BaselineProcess {

    /**
     * @var Baseline
     */
    private $baseline;


    /**
     * @param Baseline $baseline
     */
    public function __construct(Baseline $baseline) {
        if (!$baseline || get_class($baseline) != 'Baseline') {
            throw new Exception('Informe a baseline a ser gerada.');
        }
        $this->baseline = $baseline;
    }

    /**
     *
     */
    public function execute() {
//TODO: Refactor/improve the configuration, reuse and reduce the redundancy of the descriptions above
        $result = array(
            'general' => false,
            "Create Jira's version" => false,
            "Create SVN tag"        => false,
            Baseline::TYPE_TEST => array(
                "Added test artifacts in the SVN tag" => false
            ),
            Baseline::TYPE_RELEASE => array(
                "Checkout the SVN tag"                          => false,
                "Added NTR and RDM in the SVN tag"              => false,
                "Export the SVN checkout"                       => false,
                "Handle the symlinks dependencies (PHP)"        => false,
                "Compact the source directory"                  => false,
                "Compact the release directory"                 => false,
                "Put the baseline compressed file in the FTP"   => false,
                "Send availability of demands e-mail"           => false,
                "Create the release's technical revision issue" => false
            ),
            "Release the Jira's version"         => false,
            "Update source in the server"        => false,
            "Send baseline's e-mail"             => false,
            "Set the Jira's version description" => false
        );

//TODO: Get this authentication data from Parameter or other config
        $networkUser = '';
        $networkPassword = '';
        $jiraPassword = '';
        $svnPassword = '';

        if (
            empty($networkUser) || empty($networkPassword)
            || empty($jiraPassword) || empty($svnPassword)
        ) {
            throw new Exception('Users data not set.');
        }
        ############################################################################
        $this->debug("################################################################################\n");

        ############################################################################
        $this->log('Verificando se a baseline informada e os parâmetros existem.');

        $baselineTable = BaselineTable::getInstance();
        $baselineType = $this->baseline->getType();
        $parameter = ParameterTable::getInstance()->findAll()->getFirst();

        if (!$parameter) {
            throw new Exception('Parâmetros não encontrados.');
            exit;
        }

        $this->log('Baseline e parâmetros OK.');

        ############################################################################
        $this->log('Obtendo a descrição da baseline.');

        $issues = $this->getIssues($this->baseline);
$this->debug(print_r($issues, true));

        $jiraClient = new JiraAPISoapClient($parameter->getJiraBaseUrl(),
            'JIRA_PROJECT_KEY', $networkUser, $jiraPassword);

        $issuesObjects = $jiraClient->getIssues($issues);
        $issuesTypes = $jiraClient->getIssuesTypesForProject();

        if ($this->baseline->isReleaseBaseline()) {
            $issuesForReleaseSummary = $this->getReleaseSummary($issuesObjects, $issuesTypes);
$this->debug(print_r($issuesObjects, true));
        }

        $jiraVersionDescription = $baselineTable->getJiraVersionDescription(
            $this->baseline, $issuesObjects, $issuesTypes);
$this->debug(print_r($jiraVersionDescription, true));

        ############################################################################
        $this->log('Criando a baseline (version) no Jira.');
//TODO: Fix the problem to pass the date and how to set the version descriptions, this version API does not support it

        $version = $jiraClient->createVersion($this->baseline->getName());
        $this->debug(print_r($version, true));

        if ($version) {
            $result["Create Jira's version"] = true;

            $this->log('Baseline (version) criada com sucesso no Jira.');
        }

        ############################################################################
        $this->log('Criando a tag no SVN.');

        $svnBaseUrl = $parameter->getSvnBaseUrl();

        $component = $this->baseline->getSystem()->getJiraComponent();
        $systemAcronym = $this->baseline->getSystem()->getAcronym();
        $baselineName = $this->baseline->getName();

        $copyFolderSVN = null;
        $dbCopyFolderSVN = null;

//TODO: Check if the component folder do exists
//TODO: Move the base copy path to Parameter
        $copyFolderSVN = "implementacao/aplicacoes/{$component}";

        if ($dbCopyFolderSVN) {
            $copyFolderSVN = $dbCopyFolderSVN;
        }

//TODO: Get this authentication data from Parameter or other config
        $svnUser = $networkUser;

#        $svnCommandsSuffix = " --username {$svnUser} --password {$svnPassword} --no-auth-cache";
        $svnCommandsSuffix = " --username {$svnUser} --password {$svnPassword}";

//TODO: Handle folders to create according to the baseline type
        $commands = array(
            "svn mkdir {$svnBaseUrl}tags/{$component}/{$baselineName} -m \"criacao da pasta da baseline\"{$svnCommandsSuffix}",
            "svn mkdir {$svnBaseUrl}tags/{$component}/{$baselineName}/codigo -m \"criacao da pasta da baseline\"{$svnCommandsSuffix}",
            "svn copy  {$svnBaseUrl}trunk/implementacao/aplicacoes/{$component} {$svnBaseUrl}tags/{$component}/{$baselineName}/codigo/ -m \"inclusao de codigo fonte do sistema na baseline\"{$svnCommandsSuffix}"
        );
        $this->runCommand($commands);

//TODO: Implement a way to check if the SVN commands are successfull
        $result["Create SVN tag"] = true;

        $this->log('Tag no SVN criada.');

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
            $this->runCommand("svn checkout {$svnBaseUrl}tags/{$component}/{$baselineName}/ {$baselineName}{$svnCommandsSuffix}");

            $result[$baselineType]["Checkout the SVN tag"] = true;
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {

            $this->log('TODO: Adicionando o release notes e o RDM.');
//TODO: Check http://www.phpdocx.com/ for a way to user doc/docx as a template
//TODO: Add the release notes and the RDM (in some projects) files
//TODO: Set base NTR and RDM per system, and change the files according to the issues in the baseline

            $ntrBaseTo = "{$component}_CEM_NTR.doc";
            $ntrFrom = "CEM_NTR.doc";

            $rdmBaseTo = "{$component}_MF_RDM.docx";
            $rdmFrom = "{$systemAcronym}_RDM_" . date('Ymd') . ".docx";

//TODO: Make the paths and the docs per system dinamyc
            $commands = array(
                "cp /var/www/baselinegenerator/web/uploads/{$ntrBaseTo} {$baselineName}/{$ntrFrom}",
                "cp /var/www/baselinegenerator/web/uploads/{$rdmBaseTo} {$baselineName}/{$rdmFrom}",
                "cd {$baselineName} && svn add {$ntrFrom} {$rdmFrom}",
                "cd {$baselineName} && svn commit -m 'Release notes e RDM.'{$svnCommandsSuffix}"
            );
            $this->runCommand($commands);

            $result[$baselineType]["Added NTR and RDM in the SVN tag"] = true;
        }

        if ($this->baseline->isTestBaseline()) {
            $this->log('TODO: Adicionando as ETFs na baseline.');
//TODO: Adicionando as ETFs na baseline
#            $result[$baselineType]["Added test artifacts in the SVN tag"] = true;
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
//TODO: Export the working copy to produce the
            $this->runCommand("svn export {$baselineName} {$baselineName}_ftp");

            $result[$baselineType]["Export the SVN checkout"] = true;
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
//TODO: Remove/move the symlinks dependencies
#            $result[$baselineType]["Handle the symlinks dependencies (PHP)"] = true;
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
            if ($this->baseline->getSystem()->getSourceFolderCompressionType() == System::COMPRESSION_TYPE_TARGZ) {
                $this->runCommand("cd {$baselineName}_ftp/codigo && tar czf {$component}.tar.gz {$component} && rm -rf {$component}");
            } else {
                $this->runCommand("cd {$baselineName}_ftp/codigo && zip -r {$component}.zip {$component} && rm -rf {$component}");
            }

//TODO: Check if it has sucessfully compressed the directory
            $result[$baselineType]["Compact the source directory"] = true;

            $compactedName = "{$baselineName}.7z";
            $this->runCommand("7za a -t7z -m0=lzma -mx=9 -mfb=64 -md=32m -ms=on {$compactedName} {$baselineName}_ftp");

            $result[$baselineType]["Compact the release directory"] = true;
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
            $this->log('Colocando o arquivo no FTP.');

           set_include_path(get_include_path() . PATH_SEPARATOR
                . dirname(__FILE__) . '/vendor/phpseclib');
           include_once('Net/SFTP.php');

            $sftp = new Net_SFTP($parameter->getFtpHost());
            if ($sftp->login($parameter->getFtpUser(), $parameter->getFtpPassword())) {
                $ftpPath = trim($this->baseline->getSystem()->getFtpPath());

                if (isset($ftpPath[0]) && $ftpPath[0] != '/') {
                    $ftpPath = '/' . $ftpPath;
                }
                $lastChar = isset($ftpPath[strlen($ftpPath)-1])?$ftpPath[strlen($ftpPath)-1]:null;
                if ($lastChar && $lastChar != '/') {
                    $ftpPath .= $ftpPath . '/';
                }

                // copies filename.local to filename.remote on the SFTP server
                #Example: $sftp->put('filename.remote', 'filename.local', NET_SFTP_LOCAL_FILE);
                $result[$baselineType]["Put the baseline compressed file in the FTP"]
                    = $sftp->put($ftpPath . $compactedName, $compactedName,NET_SFTP_LOCAL_FILE);
            } else {
                exit('Login Failed');
            }
        }

        ############################################################################
        // Release the Jira's baseline (version)
        $this->log('Fechando a baseline no Jira.');
        $jiraClient->releaseVersion($version);

        #$result[$baselineType]["Release the Jira's version"] = true;
        $result["Release the Jira's version"] = true;

        ############################################################################
        // Update the source on the "testing" server
        $this->log('TODO: Atualizando os fontes no servidor.');
        #$result[$baselineType]["Update source in the server"] = true;
#        $result["Update source in the server"] = true;

        ############################################################################
        //TODO: Send the release e-mail
        $this->log('TODO: Enviando o e-mail');

        if (!sfContext::hasInstance()) {
            require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

            $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
            sfContext::createInstance($configuration);

            $configuration->loadHelpers('Partial');
        }

        $subject = "Baseline de " . strtolower($baselineType) . " {$baselineName}.";
        $mailer = sfContext::getInstance()->getMailer();
        $message = $mailer->compose(
            "{$networkUser}@domain.com",
            "{$networkUser}@domain.com",
            $subject);

        $html = get_partial("baseline/email{$baselineType}", array(
            'baseline'    => $this->baseline,
            'parameter'   => $parameter,
            'description' => substr($jiraVersionDescription, 0, strpos($jiraVersionDescription, '.')),
            'content'     => substr($jiraVersionDescription, strpos($jiraVersionDescription, '.')+1)
        ));

        $message->setBody($html, 'text/html');

        #$result[$baselineType]["Send baseline's e-mail"] = $mailer->send($message);
        $result["Send baseline's e-mail"] = $mailer->send($message);

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
//TODO: Send the availability of demands e-mail
            $subject = "Disponibilização de demandas do sistema "
                . $this->baseline->getSystem()->getName();
            $message = $mailer->compose(
                "{$networkUser}@domain.com",
                "{$networkUser}@domain.com",
                $subject);

            $html = get_partial("baseline/emailAvailability", array(
                'baseline'    => $this->baseline,
                'parameter'   => $parameter,
                'description' => substr($jiraVersionDescription, 0, strpos($jiraVersionDescription, '.')),
                'content'     => substr($jiraVersionDescription, strpos($jiraVersionDescription, '.')+1),
                'issues'      => $issuesForReleaseSummary
            ));

            $message->setBody($html, 'text/html');

            $result[$baselineType]["Send availability of demands e-mail"] = $mailer->send($message);
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
//TODO:
#            $result[$baselineType]["Create the release's technical revision issue"] = true
        }

        ############################################################################
        if ($this->baseline->isReleaseBaseline()) {
            $this->runCommand(array(
                "rm -rf {$compactedName}",
                "rm -rf {$baselineName}",
                "rm -rf {$baselineName}_ftp"
            ));
        }

        ############################################################################
$cmd = "echo \"\nJira Version Description:\n{$jiraVersionDescription}\n\"";
$this->runCommand($cmd);
$this->debug(print_r($result, true));
        return $result;
    }

    /**
     * @param Baseline $baseline
     * @return array
     */
    private function getIssues(Baseline $baseline) {
        $populate = function(&$issues, $unhandledIssues) {
            $unhandledIssues = explode(',', $unhandledIssues);

            if (is_array($unhandledIssues)) {
                foreach ($unhandledIssues as $key) {
                    $key = strtoupper(trim($key));
                    if ($key) {
                        array_push($issues, $key);
                    }
                }
            }
        };

        $issues = array();

        if ($baseline->getIssues()) {
            $populate($issues, $baseline->getIssues());
        }

        return $issues;
    }

    /**
     * @param array|string $command
     */
    private function runCommand($commands) {
        $this->debug(print_r($commands, true));

        if (is_array($commands)) {
            foreach ($commands as $command) {
                $output = shell_exec($command);
                $this->debug(print_r(array($command => $output), true));
                echo "$output\n";
            }
        } else {
            $output = shell_exec($commands);
            $this->debug(print_r(array($commands => $output), true));
            echo "$output\n";
        }
    }

    /**
     * @param array $issuesObjects
     * @param array $issuesTypes
     * @return array
     * @see BaselineTable::getJiraVersionDescription()
     */
    private function getReleaseSummary($issuesObjects, $issuesTypes) {
//TODO: Move the code from BaselineTable::getJiraVersionDescription() to here, where lies it's responsability, and refactor it to support with one operatione or with a better reuse the fetch of the issues per type or the summary for the release's e-mail tables
        if (is_array($issuesObjects)) {
            $issues = array(
                'bugs' => array(
                    'id' => null,
                    'issues' => array(),
                    'description' => array()
                ),
                'crs' => array(
                    'id' => null,
                    'issues' => array(),
                    'description' => array()
                ),
                'improvements' => array(
                    'id' => null,
                    'issues' => array(),
                    'description' => array()
                ),
                'demands' => array(
                    'id' => null,
                    'issues' => array(),
                    'description' => array()
                )
            );

            foreach ($issuesTypes as $key => $issueType) {
                if (strcasecmp($issueType->name, JiraAPISoapClient::ISSUE_TYPE_NAME_BUG) == 0) {
                    $issues['bugs']['id'] = $issueType->id;
                }
                if (strcasecmp($issueType->name, JiraAPISoapClient::ISSUE_TYPE_NAME_CR) == 0) {
                    $issues['crs']['id'] = $issueType->id;
                }
                if (strcasecmp($issueType->name, JiraAPISoapClient::ISSUE_TYPE_NAME_IMPROVEMENT) == 0) {
                    $issues['improvements']['id'] = $issueType->id;
                }
                if (strcasecmp($issueType->name, JiraAPISoapClient::ISSUE_TYPE_NAME_DEMAND) == 0) {
                    $issues['demands']['id'] = $issueType->id;
                }
            }

            foreach ($issuesObjects as $key => $issue) {
                switch ($issue->type) {
                    case $issues['bugs']['id']: {
                        array_push($issues['bugs']['issues'], $issue->key);
                        array_push($issues['bugs']['description'], $issue->summary);
                        break;
                    }
                    case $issues['crs']['id']: {
                        array_push($issues['crs']['issues'], $issue->key);
                        array_push($issues['crs']['description'], $issue->summary);
                        break;
                    }
                    case $issues['improvements']['id']: {
                        array_push($issues['improvements']['issues'], $issue->key);
                        array_push($issues['improvements']['description'], $issue->summary);
                        break;
                    }
                    case $issues['demands']['id']: {
                        array_push($issues['demands']['issues'], $issue->key);
                        array_push($issues['demands']['description'], $issue->summary);
                        break;
                    }
                }
            }

            return $issues;
        }

        return null;
    }

    /**
     * @param string $t
     */
    private function log($t) {
//        sfContext::getInstance()->getLogger()->info($t);
    }

    /**
     * @param string $text
     */
    private function debug($text) {
        file_put_contents(dirname(__FILE__) . '/../log/debug.log', '['
            . date('Y-m-d H:i:s') . '] ' . $text . PHP_EOL, FILE_APPEND);
    }
}