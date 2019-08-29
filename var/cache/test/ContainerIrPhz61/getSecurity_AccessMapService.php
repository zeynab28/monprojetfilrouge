<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'security.access_map' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/security-http/AccessMapInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/AccessMap.php';
include_once $this->targetDirs[3].'/vendor/symfony/http-foundation/RequestMatcherInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/http-foundation/RequestMatcher.php';

$this->privates['security.access_map'] = $instance = new \Symfony\Component\Security\Http\AccessMap();

$instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/api/register'), [0 => 'ROLE_ADMIN'], NULL);
$instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/api/ajout'), [0 => 'ROLE_SUPER_ADMIN'], NULL);
$instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/api/depot'), [0 => 'ROLE_CAISSIER'], NULL);
$instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/api/acces'), [0 => 'ROLE_USERLOCK'], NULL);

return $instance;
