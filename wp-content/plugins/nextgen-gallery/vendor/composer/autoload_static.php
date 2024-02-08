<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbf11ede52ba73f7b46b2b31c39c69c03
{
    public static $files = array (
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
        'a5dbe7df96665c0b6c16ae8d91231502' => __DIR__ . '/..' . '/imagely/pope-framework/lib/autoload.php',
    );

    public static $prefixesPsr0 = array (
        'H' => 
        array (
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitbf11ede52ba73f7b46b2b31c39c69c03::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitbf11ede52ba73f7b46b2b31c39c69c03::$classMap;

        }, null, ClassLoader::class);
    }
}
