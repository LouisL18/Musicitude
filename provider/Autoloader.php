<?php
namespace provider;

class Autoloader
{
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class) {
        $path = str_replace('\\', '/', $class);
        require __DIR__ . '/../' . $path . '.php';
    }
}
?>