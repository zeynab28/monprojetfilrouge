<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.4IbqlWj' shared service.

return $this->privates['.service_locator.4IbqlWj'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'serializer' => ['services', 'serializer', 'getSerializerService', false],
    'user' => ['privates', 'App\\Repository\\UserRepository', 'getUserRepositoryService.php', true],
], [
    'serializer' => '?',
    'user' => 'App\\Repository\\UserRepository',
]);
