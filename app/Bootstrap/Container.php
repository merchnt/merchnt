<?php
namespace App\Bootstrap;

use ArrayAccess;
use DI\Container as DIContainer;
use DI\ContainerBuilder;
use DI\NotFoundException;

class Container implements ArrayAccess
{
    /**
     * @var DIContainer
     */
    protected $container;

    /**
     * @return DIContainer
     */
    public function boot()
    {
        if (empty($this->container)) {
            $this->container = (new ContainerBuilder)->build();
        }

        return $this;
    }

    /**
     * @return DIContainer
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param $contract
     * @param $implementation
     */
    public function bind($contract, $implementation)
    {
        if (is_string($implementation)) {
            $this->container->set($contract, \DI\object($implementation));
        }

        if (is_callable($implementation) || is_object($implementation)) {
            $this->container->set($contract, $implementation);
        }
    }

    /**
     * @param $contract
     * @param $object
     */
    public function bindObject($contract, $object)
    {
        $this->container->set($contract, $object);
    }

    /**
     * @param $class
     * @return mixed
     * @throws NotFoundException
     */
    public function make($class)
    {
        return $this->container->get($class);
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->container->has($key);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->make($key);
    }

    /**
     * @param mixed $key
     * @param mixed $implementation
     */
    public function offsetSet($key, $implementation)
    {
        $this->bind($key, $implementation);
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        $this->container->set($key, null);
    }
}