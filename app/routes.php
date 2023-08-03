<?php
use App\Controllers\ProductController;
use App\Controllers\AuthController;

function handleRequest($controller)
{
    header('Content-Type: application/json');

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestUri = strtok($requestUri, '?');

    $productIdPattern = '#^/api/products/(\d+)$#';
    $productRoute = '/api/products';
    $loginRoute = '/api/login';
    $callRoute = '/api/call';

    $basePath = '/api/';
    $parts = explode($basePath, $requestUri);
    $requestUri = isset($parts[1]) ? $parts[1] : '';
    $requestUri = $basePath.$requestUri;


    if ($requestMethod === 'GET' && rtrim($requestUri, '/') === $productRoute) {
        $controller->index();
    } elseif ($requestMethod === 'GET' && preg_match($productIdPattern, rtrim($requestUri, '/'), $matches)) {
        $productId = $matches[1];
        $controller->show($productId);
    } elseif ($requestMethod === 'POST' && rtrim($requestUri, '/') === $productRoute) {
        $controller->store();
    } elseif ($requestMethod === 'PUT' && preg_match($productIdPattern, rtrim($requestUri, '/'), $matches)) {
        $productId = $matches[1];
        $controller->update($productId);
    } elseif ($requestMethod === 'DELETE' && preg_match($productIdPattern, rtrim($requestUri, '/'), $matches)) {
        $productId = $matches[1];
        $controller->destroy($productId);
    } 
    elseif ($requestMethod === 'POST' && rtrim($requestUri, '/') === $loginRoute) {
        $authController = new AuthController($controller->getConnection(), $controller->getAuth());
        $authController->login();
    }
    elseif ($requestMethod === 'GET' && rtrim($requestUri, '/') === $callRoute) {
        $controller->renderView();
    }
    else {
        http_response_code(404);
        echo json_encode(['error' => 'Route not found.']);
    }
    
}
