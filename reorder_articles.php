<?php

require "init.php";

if (isPostRequest()) {
    $article = new Article();
    if ($article->reorderAndResetAutoIncrement()) {
        redirect('admin.php');
    };
    // $article->reorderAndResetAutoIncrement();
}
