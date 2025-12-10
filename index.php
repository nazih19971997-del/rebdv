<?php
/**
 * Root Index - Laravel Application Entry Point
 * Compatible with shared hosting environments
 */

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

// Remove query string if present
$requestUri = strtok($requestUri, '?');

// If accessing /public/ directly, redirect to clean URL
if (strpos($requestUri, '/public/') === 0) {
    $cleanUrl = str_replace('/public/', '/', $requestUri);
    
    // Preserve query string if it exists
    $queryString = $_SERVER['QUERY_STRING'] ?? '';
    if (!empty($queryString)) {
        $cleanUrl .= '?' . $queryString;
    }
    
    header('Location: ' . $cleanUrl, true, 301);
    exit;
}

// Check if it's a static file in public directory
$publicPath = __DIR__ . '/public' . $requestUri;

if ($requestUri !== '/' && file_exists($publicPath) && !is_dir($publicPath)) {
    // Serve static files directly
    $mimeType = mime_content_type($publicPath);
    if ($mimeType) {
        header('Content-Type: ' . $mimeType);
    }
    readfile($publicPath);
    exit;
}

// Include Laravel's main index file
require_once __DIR__ . '/public/index.php';