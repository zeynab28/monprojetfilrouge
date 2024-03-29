<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'security.authentication.listener.basic.api' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/security-http/Firewall/ListenerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Firewall/LegacyListenerTrait.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Firewall/BasicAuthenticationListener.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Session/SessionAuthenticationStrategyInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Session/SessionAuthenticationStrategy.php';

$this->privates['security.authentication.listener.basic.api'] = $instance = new \Symfony\Component\Security\Http\Firewall\BasicAuthenticationListener(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->privates['security.authentication.manager'] ?? $this->getSecurity_Authentication_ManagerService()), 'api', ($this->privates['lexik_jwt_authentication.security.guard.jwt_token_authenticator'] ?? $this->load('getLexikJwtAuthentication_Security_Guard_JwtTokenAuthenticatorService.php')), ($this->privates['monolog.logger.security'] ?? $this->load('getMonolog_Logger_SecurityService.php')));

$instance->setSessionAuthenticationStrategy(new \Symfony\Component\Security\Http\Session\SessionAuthenticationStrategy('none'));

return $instance;
