<?php
include "./partials/admin/header.php";
include "./partials/admin/navbar.php";

$article_obj = new Article();
$article = $article_obj->get_article_with_owner_by_id($_GET['id']);
if (isset($article->image)) {
    $articleImage = $article->image;
}

if (isPostRequest()) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $owner_of_the_article = $article->owner == $_SESSION['user_id'];
    if ($owner_of_the_article) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if (file_exists($article->image)) {
                if (unlink($article->image)) {
                    echo "Error deleting an image from the directory";
                };
            }
            $imagePath = uploadImage();
        }
        $image = isset($imagePath) ? $imagePath : $articleImage;
        if ($article_obj->updateArticleById($_GET['id'], $title, $content, $image)) {
            redirect("edit_article.php?id=" .  $article->id);
        }
    }
}



?>

<main class="container my-5 edit-page">
    <h2>Edit Article</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Article Title *</label>
            <input name="title" type="text" class="form-control" id="title" value="<?= !empty($article->title) ? $article->title : 'No Title'; ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author *</label>
            <input type="text" class="form-control" id="author" disabled value="<?= !empty($article->author) ? $article->author : 'No author\'s name'; ?>" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Published Date *</label>
            <input type="date" class="form-control" id="date" value="<?= date('Y-m-d', strtotime($article->created_at)); ?>" required>
        </div>
        <div class="mb-3">
            <label for="excerpt" class="form-label">Excerpt *</label>
            <textarea class="form-control" id="excerpt" rows="3" required>Current article excerpt...</textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content *</label>
            <textarea name="content" class="form-control" id="content" rows="10" required><?= !empty($article->content) ? $article->content : 'No content specified'; ?></textarea>
        </div>
        <div class="mb-3">
            <?php if (!empty($article->image)): ?>
                <small>Current file: <?php echo $article->image ?> </small></br>
            <?php else: ?>
                <small>No image exists</small>
            <?php endif; ?>
            <?php if (file_exists($article->image)): ?>
                <small>Current image:</small><br>
                <img src="<?= $article->image ?>"
                    class="img-fluid-small"
                    alt="Blog Post Image"><br>
            <?php endif; ?>

            <label for="file" class="form-label">Featured Image URL</label>
            <small>(Choose a new image in order to change the current one)</small>
            <input name="image" type="file" class="form-control" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Update Article</button>
        <a href="admin.html" class="btn btn-secondary ms-2">Cancel</a>
        <div style="margin-bottom: 100px;"></div>
    </form>
</main>


<?php
include "./partials/admin/footer.php";

?>