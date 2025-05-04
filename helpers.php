<?php

function baseUrl($path = '')
{
    $protocol =  isset($_SERVER['HTTPS']) && $_SERVER !== 'off' ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];

    $baseURL = $protocol . $host;

    return $baseURL . ltrim($path, "/");
}

function basePath($path = '')
{
    $rootPath = dirname(__DIR__);

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
