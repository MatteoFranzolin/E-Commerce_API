<?php

// Array associativo per mappare le route
$routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
];

// Aggiungi routes
function addRoute($method, $path, $callback)
{
    global $routes;
    $routes[$method][$path] = $callback;
}

// richiesta HTTP
function getRequestMethod()
{
    return $_SERVER['REQUEST_METHOD'];
}

// path
function getRequestPath()
{
    $path = $_SERVER['REQUEST_URI'];
    $path = parse_url($path, PHP_URL_PATH);
    return rtrim($path, '/');
}

// gestione richiesta
function handleRequest()
{
    global $routes;

    $method = getRequestMethod();
    $path = getRequestPath();

    if (isset($routes[$method])) {
        foreach ($routes[$method] as $routePath => $callback) {
            // Verifica se il percorso richiesto corrisponde al percorso della route
            if (preg_match('#^' . $routePath . '$#', $path, $matches)) {
                call_user_func_array($callback, $matches);
                return;
            }
        }
    }

    // 404 se la route non è stata trovata
    http_response_code(404);
    echo "404 Not Found";
}

//CONTROLLERS
require_once __DIR__.'/app/controllers/ProductController.php';

//Aggiungi qui le routes

$productsPageCallback = function () {
    $controller = new ProductController();
    $controller->view();
    echo "Gestisci richiesta GET per tutti i prodotti";
};
$addProduct = function(){
    $controller = new ProductController();
    $controller->add();
};
addRoute('GET', '/products', $productsPageCallback);
addRoute('POST', '/products', $addProduct);


$singleproductpageCallback = function ($matches) {
    $parts = explode('/', $matches); //divide la stringa in base agli /
    $id = end($parts); //prende l'ultimo elemento dell'array che è l'id
    echo "Gestisci richiesta GET per il prodotto con ID: $id";
};

addRoute('GET', '/products/(\d+)', $singleproductpageCallback);
addRoute('DELETE', '/products/(\d+)', $singleproductpageCallback);
addRoute('PATCH', '/products/(\d+)', $singleproductpageCallback);

// Gestore delle richieste
handleRequest();