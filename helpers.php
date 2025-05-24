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

function isLoggedIn()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}
function uploadImage()
{
    $targetDir = 'uploads' .  DIRECTORY_SEPARATOR;
    $imagePath = '';
    $error = '';


    if (!strpos($_SERVER['PHP_SELF'], 'edit_article.php')) {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    }


    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // var_dump($_FILES);
        $targetFile = $targetDir . $_FILES['image']['name'];
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {

            $uniqueFileName = uniqid() . "_" . time() . "." . $imageFileType;
            $targetFile .= "_" . $uniqueFileName;
            if (move_uploaded_file($_FILES['image']["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
            } else {

                $error = 'There was an error uploading the file';
                echo $error;
            }
        } else {
            $error = 'Only JPG, JPEG, PNG and GIF types are allowed';
            echo $error;
        }
        if (strpos($_SERVER['PHP_SELF'], 'edit_article.php')) {
            return $imagePath;
        }
    }
}
