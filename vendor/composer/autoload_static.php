<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaed3f962dfbfefc013cffd321fd02f48
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaed3f962dfbfefc013cffd321fd02f48::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaed3f962dfbfefc013cffd321fd02f48::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaed3f962dfbfefc013cffd321fd02f48::$classMap;

        }, null, ClassLoader::class);
    }
}
