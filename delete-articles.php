<?php
include_once 'init.php';
header('Content-Type : application/json');

if (isPostRequest()) {
    var_dump('HELLO');
}
