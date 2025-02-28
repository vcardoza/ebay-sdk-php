<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit620b63f03626072dec7f8ffd0ba35393
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Cardoza\\Ebay\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Cardoza\\Ebay\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit620b63f03626072dec7f8ffd0ba35393::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit620b63f03626072dec7f8ffd0ba35393::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit620b63f03626072dec7f8ffd0ba35393::$classMap;

        }, null, ClassLoader::class);
    }
}
