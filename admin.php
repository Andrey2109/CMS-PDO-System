<?php
include "./partials/admin/header.php";
include "./partials/admin/navbar.php";

$article_obj = new Article();


$user_articles = !empty($article_obj->getArticlesbyUser($_SESSION['user_id'])) ? $article_obj->getArticlesbyUser($_SESSION['user_id']) : [];
// var_dump($user_articles);

?>

<!-- Main Content -->
<main class="container my-5">
    <h2 class="mb-4">Welocme <?= $_SESSION['username'] ?> to your Admin page</h2>

    <!-- Articles Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Excerpt</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_articles as $article): ?>
                    <tr>
                        <td><?= $article->id ?></td>
                        <td><?= $article->title ?></td>
                        <td><?= $article->first_name . ' ' . $article->last_name ?></td>
                        <td><?= $article_obj->formatCreatedAt($article->created_at) ?></td>
                        <td>
                            <?= $article_obj->getProperLength($article->content)  ?>
                        </td>
                        <td>
                            <a href="edit_article.php?id=<?= $article->id ?>" class="btn btn-sm btn-primary me-1">Edit</a>
                        </td>
                        <td>
                            <form method="POST" action="delete-article.php">
                                <input type="hidden" name="article_id" value="<?= $article->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $article->id ?>)">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>


<?php
include "./partials/admin/footer.php";

?>