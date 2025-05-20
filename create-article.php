<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "./partials/admin/header.php";
include "./partials/admin/navbar.php";

if (isPostRequest()) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];
    $article = new Article();


    $targetDir = 'uploads' .  DIRECTORY_SEPARATOR;
    $imagePath = '';
    $error = '';


    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // var_dump($_FILES);
        $targetFile = $targetDir . $_FILES['image']['name'];
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            echo 'we are here';
            if (move_uploaded_file($_FILES['image']["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
                echo $imagePath;
            } else {

                $error = 'There was an error uploading the file';
                echo $error;
            }
        } else {
            $error = 'Only JPG, JPEG, PNG and GIF types are allowed';
            echo $error;
        }
    }
    if ($article->createArticle($title, $content, $imagePath, $date, $user_id)) {
        redirect('admin.php');
    }
}


?>

<main class="container my-5">
    <h2>Create New Article</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Article Title *</label>
            <input name="title" type="text" class="form-control" id="title" placeholder="Enter article title" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Published Date *</label>
            <input name="date" type="date" class="form-control" id="date" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content *</label>
            <textarea name="content" class="form-control" id="content" rows="10" placeholder="Enter article content" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Featured Image</label>
            <input name="image" type="file" class="form-control" id="image" placeholder="Upload image file">
        </div>
        <button type="submit" class="btn btn-success">Publish Article</button>
        <a href="admin.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</main>


<?php
include "./partials/admin/footer.php";

?>