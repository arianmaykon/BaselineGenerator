<?php
/**
 * Client for the Jira soap API.
 * Tested with Atlassian JIRA version (v4.4.1#660-r161644).
 *
 * @see http://docs.atlassian.com/rpc-jira-plugin/4.4/
 * @todo Refactor the constants to another thing who should colect this data per project
 */
class JiraAPISoapClient {

	/**
	 * @var array
	 */
	const ISSUE_TYPE_NAME_BUG = 'Bug';

	/**
	 * @var array
	 */
	const ISSUE_TYPE_NAME_IMPROVEMENT = 'Improvement';

	/**
	 * @var array
	 */
	const ISSUE_TYPE_NAME_CR = 'Requirement change';

	/**
	 * @var array
	 */
	const ISSUE_TYPE_NAME_DEMAND = 'Item de Backlog';


	/**
	 * @var string
	 */
	private $_wsdlUrlSufix = 'rpc/soap/jirasoapservice-v2?wsdl';

	/**
	 * @var string
	 */
	private $_wsdlUrlBase;

	/**
	 * @var string
	 */
	private $_user;

	/**
	 * @var string
	 */
	private $_password;

	/**
	 * @var string
	 */
	private $_projectKey;

	/**
	 * @var SoapClient
	 */
	private $_clientInstance;
	
	/**
	 * @var string
	 */
	private $_token;


	/**
	 * @param string $wsdlUrlBase
	 * @param string $projectKey
	 * @param string $user
	 * @param string $password
	 */
	public function __construct($wsdlUrlBase=null, $projectKey=null, $user=null, $password=null) {
		$this->setWsdlUrlBase($wsdlUrlBase);
		$this->setProjectKey($projectKey);
		$this->setUser($user);
		$this->setPassword($password);
	}

	/**
	 * @param string $wsdlUrlBase
	 */
	public function setWsdlUrlBase($wsdlUrlBase) {
		$this->_wsdlUrlBase = $wsdlUrlBase;
	}

	/**
	 * @param string $user
	 */
	public function setUser($user) {
		$this->_user = $user;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->_password = $password;
	}

	/**
	 * @param string $password
	 */
	public function setProjectKey($projectKey) {
		$this->_projectKey = $projectKey;
	}

	/**
	 * @return SoapClient
	 */
	private function getClient() {
		if (!$this->_clientInstance) {
			$this->_clientInstance = new SoapClient(
				$this->_wsdlUrlBase . $this->_wsdlUrlSufix,
				array('trace' => TRUE)
			);
		}

		if (!$this->_token) {
			$this->login();
		}

		return $this->_clientInstance;
	}

	/**
	 *
	 */
	private function login() {
		$this->_token = $this->_clientInstance->login($this->_user, $this->_password);
	}

	/**
	 *
	 */
	public function create() {
		$remoteVersion = new stdClass();
		$remoteVersion->name = 'testenho';
		$remoteVersion->released = false;
		$remoteVersion->archived = false;
		#$remoteVersion->sequence;
		#$remoteVersion->releaseDate;

		$result = $this->getClient()->addVersion($this->_token, $this->_projectKey, $remoteVersion);
	}

	/**
	 * @param string $issue
	 * @return object
	 */
	public function getIssue($issue) {
		return $this->getClient()->getIssue($this->_token, $issue);
	}

	/**
	 * @param string $fixVersion
	 * @return array
	 */
	public function getIssuesByFixVersion($fixVersion) {
		return $this->getIssuesFromJqlSearch('fixVersion = ' . $fixVersion
			. ' ORDER BY issuetype');
	}

	/**
	 * @param string|array $issues
	 * @return array
	 */
	public function getIssues($issues) {
		if (is_array($issues)) {
			$issues = implode(',', $issues);
		}

		return $this->getIssuesFromJqlSearch('issuekey in (' . $issues
			. ') ORDER BY issuetype');
	}

	/**
	 * @param string $query
	 * @return array
	 */
	public function getIssuesFromJqlSearch($query) {
		return $this->getClient()->getIssuesFromJqlSearch(
			$this->_token, $query, 100);
	}

	/**
	 * @return array
	 */
	public function getIssuesTypesForProject() {
		$project = $this->getClient()->getProjectByKey($this->_token, $this->_projectKey);

		return $this->getClient()->getIssueTypesForProject($this->_token, $project->id);
	}

	/**
	 * @param string name
	 * @param string $description (unused)
	 * @return object stdClass which represent the RemoteVersion object in Jira API
	 */
	public function createVersion($name, $description=null) {
		$remoteVersion = new stdClass();
		$remoteVersion->name = $name;
		$remoteVersion->released = false;
		$remoteVersion->archived = false;
		#$remoteVersion->sequence;
		#$remoteVersion->releaseDate;

		return $this->getClient()->addVersion($this->_token,
			$this->_projectKey, new SoapParam($remoteVersion, 'in2'));
	}

	/**
	 * @param object $version strClass which represents a RemoteVersion in Jira's API
	 */
	public function releaseVersion($version) {
		$version->released = true;

		$this->getClient()->releaseVersion($this->_token,
			$this->_projectKey, new SoapParam($version, 'version'));
	}
}