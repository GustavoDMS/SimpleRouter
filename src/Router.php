<?php

namespace gustavodms\simplerouter;

use Closure;

class Router
{
    private static array $routes = array();
    private static function route(string $method, string $uri, Closure|array|string|null $action = null)
    {
        $route = array(
            "route" => $uri,
            "method" => $method,
            "action" => $action
        );
        self::$routes[] = $route;
    }
    public static function GET(string $uri, Closure|array|string|null $action = null)
    {
        self::route('GET', $uri, $action);
    }

    public static function POST(string $uri, Closure|array|string|null $action = null)
    {
        self::route('POST', $uri, $action);
    }

    public static function PUT(string $uri, Closure|array|string|null $action = null)
    {
        self::route('PUT', $uri, $action);
    }

    public static function DELETE(string $uri, Closure|array|string|null $action = null)
    {
        self::route('DELETE', $uri, $action);
    }

    public static function PATCH(string $uri, Closure|array|string|null $action = null)
    {
        self::route('PATCH', $uri, $action);
    }

    public static function Initialize(): void
    {
        $fullUri = $_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($fullUri);
        $uri = ltrim($parsedUrl['path'], '/');

        $method = $_SERVER['REQUEST_METHOD'];


        foreach (self::$routes as $key => $route) {
            $routeSegments = explode("/", $route['route']);
            $uriSegments = explode("/", $uri);
            if (count($routeSegments) === count($uriSegments) && $method == $route['method']) {
                $matched = true;
                $params = [];

                for ($i = 0; $i < count($routeSegments); $i++) {
                    $routeSegment = $routeSegments[$i];
                    $uriSegment = $uriSegments[$i];


                    if (preg_match('/^\{(.+)\}$/', $routeSegment, $matches)) {
                        $paramName = $matches[1];
                        $params[$paramName] = $uriSegment;
                    } elseif ($routeSegment !== $uriSegment) {
                        $matched = false;
                        break;
                    }
                }
                if ($matched) {
                    $response = new ResponseWriter();
                    $request = Request::Initialize($params);

                    $action = $route['action'];

                    if ($action instanceof Closure) {
                        $action($request, $response);
                    } elseif (is_array($action)) {
                        $controller = $action[0];
                        $controller = new $controller();
                        $method = $action[1];
                        $parameters = [$request, $response];
                        call_user_func_array([$controller, $method], $parameters);
                    } elseif (is_string($action)) {

                        $parts = explode('@', $action);
                        $controller = $parts[0];
                        $method = $parts[1];
                        $controller = new $controller();
                        $parameters = [$request, $response];
                        call_user_func_array([$controller, $method], $parameters);
                        // ...
                    } elseif ($action === null) {

                    } else {

                    }
                }
            }
        }
    }
}
