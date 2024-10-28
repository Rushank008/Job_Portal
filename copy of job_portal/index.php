<?php
$routes = require 'routes.php';  // Load routes from routes.php

// Get the requested URL path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Function to display 404 if route is not found
function abort($code = 404) {
    http_response_code($code);    // Set HTTP response code (404 in this case)
    require 'views/404.php';  // Load custom 404 view
    exit();
}

// Check if the requested URI exists in the routes array
if (array_key_exists($uri, $routes)) {
    require  $routes[$uri];  // Load the corresponding controller
} else {
    abort();  // Display 404 error if the route is not found
}