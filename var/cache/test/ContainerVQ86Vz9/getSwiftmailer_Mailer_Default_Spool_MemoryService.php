<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'swiftmailer.mailer.default.spool.memory' shared service.

include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Spool.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/MemorySpool.php';

return $this->privates['swiftmailer.mailer.default.spool.memory'] = new \Swift_MemorySpool();
