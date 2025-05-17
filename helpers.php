<?php

function baseUrl($path = '')
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];

    // Ensure PROJECT_DIR has leading slash but no trailing slash
    $dir = '/' . trim(PROJECT_DIR, '/');
    if ($dir == '/') $dir = '';

    $baseURL = $protocol . $host . $dir . '/';

    return $baseURL . ltrim($path, "/");
}

function basePath($path = '')
{
    $rootPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . PROJECT_DIR;

    return $rootPath . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
}

function uploadsPath($filepath)
{
    return basePath('uploads' . DIRECTORY_SEPARATOR . ltrim($filepath, DIRECTORY_SEPARATOR));
}

function uploadsURL($filepath)
{
    return basePath('uploads/' . ltrim($filepath, '/'));
}

function assetsURL($filepath)
{
    return basePath('ussets/' . ltrim($filepath, '/'));
}

function redirect($url)
{
    header("Location: " . baseUrl($url));
    exit;
}

function isPostRequest()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function getPostData($field, $default = null)
{
    return isset($_POST[$field]) ? trim($_POST[$field]) : $default;
}

function formatCreatedAt($date)
{
    return date('F j, Y', strtotime($date));
}
