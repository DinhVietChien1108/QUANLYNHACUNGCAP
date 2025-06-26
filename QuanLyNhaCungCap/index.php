<?php
session_start();

// Include configuration and helper files
require_once 'config/database.php';
require_once 'helpers/functions.php';

// Define base URL
define('BASE_URL', '/');

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/QuanLyNhaCungCap/', '/', $request);

// Default controller and action
$controller = 'home';
$action = 'index';
$id = null;

// Parse URL
$url_parts = parse_url($request);
$path = isset($url_parts['path']) ? $url_parts['path'] : '/';
$path = trim($path, '/');
$path_parts = explode('/', $path);

// Get controller, action and ID if available
if (!empty($path_parts[0])) {
    $controller = $path_parts[0];
}
if (!empty($path_parts[1])) {
    $action = $path_parts[1];
}
if (!empty($path_parts[2])) {
    $id = $path_parts[2];
}

// Authentication check
$public_pages = ['login', 'auth'];
if (!isset($_SESSION['user_id']) && !in_array($controller, $public_pages)) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

// Load controller
$controller_file = 'controllers/' . $controller . '_controller.php';
if (file_exists($controller_file)) {
    require_once $controller_file;
    $controller_name = ucfirst($controller) . 'Controller';
    $controller_instance = new $controller_name();
    
    // Call action method if exists
    if (method_exists($controller_instance, $action)) {
        $controller_instance->$action($id);
    } else {
        // Action not found
        require_once 'views/errors/404.php';
    }
} else {
    // Controller not found
    require_once 'views/errors/404.php';
}
?>
