<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerHRgyU9v\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerHRgyU9v/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerHRgyU9v.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerHRgyU9v\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerHRgyU9v\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'HRgyU9v',
    'container.build_id' => 'ef6bc475',
    'container.build_time' => 1568765130,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerHRgyU9v');
