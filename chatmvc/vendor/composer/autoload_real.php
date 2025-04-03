<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd60ca1c33fba222f6129c6a8bea80382
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitd60ca1c33fba222f6129c6a8bea80382', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd60ca1c33fba222f6129c6a8bea80382', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd60ca1c33fba222f6129c6a8bea80382::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
