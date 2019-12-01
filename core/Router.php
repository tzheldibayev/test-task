<?php

namespace Core;

/**
 * Class Router.
 */
class Router
{
    private $routes = [];
    private $baseRoute = '';
    private $requestedMethod = '';
    protected $notFoundCallback;

    public function addRoute($pattern, $fn)
    {
        $this->match('GET', $pattern, $fn);
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function run($callback = null): bool
    {
        $this->requestedMethod = $this->getRequestMethod();
        $matched = 0;
        if (isset($this->routes[$this->requestedMethod])) {
            $matched = $this->handle($this->routes[$this->requestedMethod], true);
        }

        if ($matched === 0) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            $this->invoke($this->notFoundCallback);
        } else {
            if ($callback && is_callable($callback)) {
                $callback();
            }
        }

        return $matched !== 0;
    }

    public function getCurrentUri(): string
    {
        return rawurldecode($_SERVER['REQUEST_URI']);
    }

    public function set404($fn)
    {
        $this->notFoundCallback = $fn;
    }

    private function handle($routes)
    {
        $matched = 0;

        $uri = $this->getCurrentUri();

        foreach ($routes as $route) {
            if (preg_match_all('#^' . $route['pattern'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                $matches = array_slice($matches, 1);
                $params = array_map(function ($match, $index) use ($matches) {
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                    }

                    return isset($match[0][0]) ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));
                $this->invoke($route['fn'], $params);

                ++$matched;
            }
        }

        return $matched;
    }

    private function invoke($fn, $params = [])
    {
        if (is_callable($fn)) {
            call_user_func_array($fn, $params);
        } else {
            [$controller, $method] = explode('@', $fn);
            if (class_exists($controller)) {
                call_user_func_array([new $controller(), $method], $params);
            }
        }
    }

    private function match($methods, $pattern, $fn): void
    {
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->routes[$method][] = [
                'pattern' => $pattern,
                'fn' => $fn,
            ];
        }
    }

}