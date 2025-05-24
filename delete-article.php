<?php
include "./partials/admin/header.php";
include "./partials/admin/navbar.php";
isLoggedIn();
if (isPostRequest()) {
    if (isset($_POST['article_id'])) {
        $id = $_POST['article_id'];
        $article_obj = new Article();
        $article = $article_obj->get_article_with_owner_by_id($id);
        $owner_of_the_article = $article->owner == $_SESSION['user_id'];
        if ($owner_of_the_article) {
            if (file_exists($article->image)) {
                if (unlink($article->image)) {
                    echo "Error deleting an image from the directory";
                };
            }
            if ($article_obj->deleteArticle($id)) {
                redirect('admin.php');
            } else {
                echo "Failed to delete an article object";
            }
        } else {
            echo "<script>
                    alert('Only the owner of the article can delete it');
                    window.location.href = 'admin.php';
                 </script>";
        }
    }
}
?>
<?php
include "./partials/admin/footer.php";

?>