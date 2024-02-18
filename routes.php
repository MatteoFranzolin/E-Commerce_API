<?php

// Definisci un array associativo per mappare le route
$routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
];

// Funzione per aggiungere una route
function addRoute($method, $path, $callback) {
    global $routes;
    $routes[$method][$path] = $callback;
}

// Funzione per ottenere il metodo della richiesta HTTP
function getRequestMethod() {
    return $_SERVER['REQUEST_METHOD'];
}

// Funzione per ottenere il percorso richiesto
function getRequestPath() {
    $path = $_SERVER['REQUEST_URI'];
    $path = parse_url($path, PHP_URL_PATH);
    return rtrim($path, '/');
}

// Funzione per gestire la richiesta
function handleRequest() {
    global $routes;

    $method = getRequestMethod();
    $path = getRequestPath();

    // Verifica se esiste una route per il metodo e il percorso richiesti
    if (isset($routes[$method])) {
        foreach ($routes[$method] as $routePath => $callback) {
            // Verifica se il percorso richiesto corrisponde al percorso della route
            if (preg_match('#^' . $routePath . '$#', $path, $matches)) {
                // Chiamata al callback passando l'ID come parametro
                call_user_func_array($callback, $matches);
                return;
            }
        }
    }

    // Ritorna un errore 404 se la route non è stata trovata
    http_response_code(404);
    echo "404 Not Found";
}

//Aggiungi qui le routes

$productspageCallback = function() {
    echo "Gestisci richiesta GET per tutti i prodotti";
};

addRoute('GET', '/products', $productspageCallback);
addRoute('POST', '/products', $productspageCallback);


$singleproductpageCallback = function($matches) {
    $parts = explode('/', $matches); //divide la stringa in base agli /
    $id = end($parts); //prende l'ultimo elemento dell'array che è l'id
    echo "Gestisci richiesta GET per il prodotto con ID: $id";
};
addRoute('GET', '/products/(\d+)', $singleproductpageCallback);
addRoute('DELETE', '/products/(\d+)', $singleproductpageCallback);
addRoute('PATCH', '/products/(\d+)', $singleproductpageCallback);

// Gestore delle richieste
handleRequest();