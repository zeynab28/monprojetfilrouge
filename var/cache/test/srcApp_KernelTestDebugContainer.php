<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerVQ86Vz9\srcApp_KernelTestDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerVQ86Vz9/srcApp_KernelTestDebugContainer.php') {
    touch(__DIR__.'/ContainerVQ86Vz9.legacy');

    return;
}

if (!\class_exists(srcApp_KernelTestDebugContainer::class, false)) {
    \class_alias(\ContainerVQ86Vz9\srcApp_KernelTestDebugContainer::class, srcApp_KernelTestDebugContainer::class, false);
}

return new \ContainerVQ86Vz9\srcApp_KernelTestDebugContainer([
    'container.build_hash' => 'VQ86Vz9',
    'container.build_id' => 'e8486c6c',
    'container.build_time' => 1565000538,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerVQ86Vz9');
