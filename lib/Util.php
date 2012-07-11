<?php
/**
 * Classe de operações auxiliares, utilitárias à aplicação.
 *
 * @package    cemar
 * @subpackage util
 */
class Util {

    /**
     * Container estático de variáveis da classe.
     *
     * @var array
     */
    private static $_varHolder = array();


    /**
     * Get a var from the static container.
     *
     * @param string $varName Nome da variável.
     * @return mixed
     */
    public static function getVar($varName) {
        if (isset(self::$_varHolder[$varName])) {
            return self::$_varHolder[$varName];
        }
    }

    /**
     * Sets a var to the static container.
     *
     * @param string $varName
     * @param mixed $content
     * @throws sfException
     * @return void
     */
    public static function setVar($varName, $content) {
        if (isset(self::$_varHolder[$varName])) {
            throw new sfException('Variável já existe!');
        }
        self::$_varHolder[$varName] = $content;
    }

    /**
     * @return adLDAP
     */
    public static function getLdap() {
        $ldap = self::getVar('ldap');
        if (is_null($ldap)) {
            require_once sfConfig::get('sf_lib_dir') . DIRECTORY_SEPARATOR
                . 'vendor' . DIRECTORY_SEPARATOR . 'adLDAP'
                . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
                . 'adLDAP.php';

            $ldap = new adLDAP(array(
                'account_suffix'     => sfConfig::get('app_ldap_account_suffix'),
                'base_dn'            => sfConfig::get('app_ldap_base_dn'),
                'domain_controllers' => sfConfig::get('app_ldap_domain_controllers')
            ));
            self::setVar('ldap', $ldap);
        }
        return $ldap;
    }

    /**
     * @param string $toMail
     * @param string $toName
     * @param string $body
     * @param string $configMailerKey
     * @param string $subject
     * @return bool
     */
    public static function sendMail($toMail, $toName, $body, $configMailerKey, $subject=null) {
        if (!sfConfig::has($configMailerKey)) {
            throw new Exception('Configurações de e-mail não encontradas['
                . $configMailerKey . ']!');
        }
        $mailerSettings = sfConfig::get($configMailerKey);

        $subject = $subject?$subject:$mailerSettings['subject'];

        $message = Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($subject)
            ->setFrom($mailerSettings['from'], $mailerSettings['fromName'])
            ->setTo($toMail, $toName)
            ->setBody($body);
        return sfContext::getInstance()->getMailer()->send($message);
    }
}