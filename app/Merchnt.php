<?php
namespace App;

use App\Bootstrap\Container;
use App\Bootstrap\Dispatcher;

class Merchnt
{
    /**
     * @var Merchnt
     */
    private static $instance;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @return Merchnt
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function make()
    {
        array_map(function(string $name, string $class) {
            $this->{$name} = (new $class())->boot();
        }, array_keys([
            'container' => 'App\Bootstrap\Container',
            'dispatcher' => 'App\Bootstrap\Dispatcher'
        ]),[
            'container' => 'App\Bootstrap\Container',
            'dispatcher' => 'App\Bootstrap\Dispatcher'
        ]);

        return $this;
    }

    public function run()
    {
        $this->getDispatcher()->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    protected function __construct()
    {
        //
    }

    private function __clone()
    {
        //
    }

    private function __wakeup()
    {
        //
    }
}