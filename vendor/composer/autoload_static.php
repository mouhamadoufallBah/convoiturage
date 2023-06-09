<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit38525cdedc34fb56b7b5ac5de0e00658
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Convoiturage\\Convoiturage\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Convoiturage\\Convoiturage\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit38525cdedc34fb56b7b5ac5de0e00658::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit38525cdedc34fb56b7b5ac5de0e00658::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit38525cdedc34fb56b7b5ac5de0e00658::$classMap;

        }, null, ClassLoader::class);
    }
}
