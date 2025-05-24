<?php
include "./partials/admin/header.php";
include "./partials/admin/navbar.php";
isLoggedIn();
if (isPostRequest()) {
    if (isset($_POST['article_id'])) {
        $id = $_POST['article_id'];
        $article_obj = new Article();
        if ($article_obj->deleteArticle($id)) {
            redirect('admin.php');
        }
    }
}
?>

<?php
include "./partials/admin/footer.php";

?>
