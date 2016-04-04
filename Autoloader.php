<?php

namespace Word;


class Autoloader
{

    private function load($class) {

        if(strpos($class, 'Word') === 0) {

            $class = substr($class, 4);
            $class = str_replace('\\', '/', $class);
            $class = WORD_ROOT . $class . '.php';

            if(file_exists($class)) {
                require_once $class;
            } else {
                throw new \Exception('Class ' . $class . ' in lib word not found');
            }
        }
    }

    public static function register() {
        $autoloader = new \Word\Autoloader();
        spl_autoload_register(array($autoloader, 'load'));
    }
}