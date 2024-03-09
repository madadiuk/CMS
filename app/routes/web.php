<?php

// Define your routes as an associative array where the key is the URI and the value is the callback that handles the request.
$routes = [
    '/' => function() {
        echo "Homepage";
        // Here you can include the logic to show the homepage or call a controller method
    },
    '/register' => ['App\Controllers\Auth\AuthController', 'register']
    // Add more routes here
];

// Get the current path from the URL, trimming any leading or trailing slashes
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Check if there's a route defined for the path
if (array_key_exists($path, $routes)) {
    $route = $routes[$path];

    // If the route's value is a callable function, just call it
    if (is_callable($route)) {
        call_user_func($route);
    }
    // If the route's value is an array, it's assumed to be [ControllerName, MethodName]
    elseif (is_array($route) && count($route) === 2) {
        [$controllerName, $methodName] = $route;
        $controller = new $controllerName();
        call_user_func([$controller, $methodName]);
    }
} else {
    // If no route is defined for the path, return a 404 response
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
    // Optionally, include a 404.php view here
}
