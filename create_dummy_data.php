<?php

require "init.php";

if (isPostRequest()) {
    $article = new Article();
    $num_of_articles = $_POST['article_count'];
    if ($article->generateDummyData($num_of_articles)) {
        redirect('admin.php');
    }
}
