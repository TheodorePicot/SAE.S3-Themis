<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit94ea378e1ca39850059f8da2f3aa11c0
{
    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit94ea378e1ca39850059f8da2f3aa11c0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit94ea378e1ca39850059f8da2f3aa11c0::$classMap;

        }, null, ClassLoader::class);
    }
}
