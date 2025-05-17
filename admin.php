<?php
include "./partials/admin/header.php";
include "./partials/admin/navbar.php";

isLoggedIn();
$article_obj = new Article();


$user_articles = $article_obj->getArticlesbyUser($_SESSION['user_id']);
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
                    <th>Actions</th>
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
                            <a href="edit-article.html?id=<?= $article->id ?>" class="btn btn-sm btn-primary me-1">Edit</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(1)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Additional Article Rows -->
                <tr>
                    <td>2</td>
                    <td>Article Title 2</td>
                    <td>Jose Diaz</td>
                    <td>February 15, 2045</td>
                    <td>
                        Quisque fermentum, nisl a pulvinar tincidunt, nunc purus laoreet massa, nec tempor arcu urna vel nisi...
                    </td>
                    <td>
                        <a href="edit-article.html?id=2" class="btn btn-sm btn-primary me-1">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(2)">Delete</button>
                    </td>
                </tr>
                <!-- You can add more articles here -->
            </tbody>
        </table>
    </div>
</main>


<?php
include "./partials/admin/footer.php";

?>