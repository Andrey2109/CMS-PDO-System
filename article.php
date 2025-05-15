<?php
require_once "./partials/header.php";
include basepath("./partials/navbar.php");
include basepath("./partials/hero.php");



$db = new Database;
$db->getConnection();
// var_dump($db);
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$article_obj = new Article;
$article = $article_obj->get_article_by_id($articleId);
// echo "<pre>";
// var_dump($article);
// echo "</pre>";
?>

<main class="container my-5">
    <h2><?= $article->title; ?></h2>
    <div class="mb-4">
        <?php if (!empty($article->image)): ?>
            <img
                src="<?php echo htmlspecialchars($article->image); ?>"
                class="img-fluid"
                alt="Blog Post Image">

        <?php else: ?>
            <img
                src="https://via.placeholder.com/350x200"
                class="img-fluid"
                alt="Blog Post Image">

        <?php endif; ?>
    </div>
    <!-- Article Content -->
    <article>
        <?= htmlspecialchars($article->content) ?>
    </article>

    <!-- Comments Section Placeholder -->
    <section class="mt-5">
        <h3>Comments</h3>
        <p>
            <!-- Placeholder for comments -->
            Comments functionality will be implemented here.
        </p>
    </section>

    <!-- Back to Home Button -->
    <div class="mt-4">
        <a href="index.html" class="btn btn-secondary">← Back to Home</a>
    </div>
</main>

<?php
include "./partials/footer.php"
?>