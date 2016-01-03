<?php
namespace App\Bootstrap;

use FastRoute\Dispatcher as FastRouteDispatcher;
use FastRoute\RouteCollector;

class Dispatcher
{
    /**
     * @var FastRouteDispatcher
     */
    protected $dispatcher;

    /**
     * @return FastRouteDispatcher
     */
    public function boot()
    {
        if (empty($this->dispatcher)) {
            $this->dispatcher = \FastRoute\cachedDispatcher(
                function(RouteCollector $routeCollector) {
                    $routes = [
                        [
                            'method' => 'GET',
                            'uri' => '/',
                            'action' => ['App\Controllers\HomeController', 'index']
                        ]
                    ];
                    foreach ($routes as $route) {
                        $routeCollector->addRoute($route['method'], $route['uri'], $route['action']);
                    }
                }, ['cacheFile' => __DIR__ . '/../../cache/routes.cache']
            );
        }

        return $this;
    }

    /**
     * @return FastRouteDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    public function dispatch($method, $uri)
    {
        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        switch ($routeInfo[0]) {
            case FastRouteDispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case FastRouteDispatcher::METHOD_NOT_ALLOWED:
                echo '405 Method Not Allowed';
                break;
            case FastRouteDispatcher::FOUND:
                container()->getContainer()->call($routeInfo[1], $routeInfo[2]);
                break;
        }
    }
}