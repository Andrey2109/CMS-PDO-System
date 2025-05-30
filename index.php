<?php
require_once "./partials/header.php";
include basepath("./partials/navbar.php");
include basepath("./partials/hero.php");

$db = new Database;
$db->getConnection();
// var_dump($db);

$article_obj = new Article;
$articles = $article_obj->get_all();
// echo "<pre>";
// var_dump($articles);
// echo "</pre>";
?>

<main class="container my-5">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <!-- Blog Post 1 -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <?php if (!empty($article->image)): ?>
                        <a href="article.php?id=<?php echo $article->id ?>">
                            <img
                                src="<?php echo htmlspecialchars($article->image); ?>"
                                class="img-fluid"
                                alt="Blog Post Image">
                        </a>
                    <?php else: ?>
                        <a href="article.php?id=<?php echo $article->id ?>">
                            <img
                                src="https://via.placeholder.com/350x200"
                                class="img-fluid"
                                alt="Blog Post Image">
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <h2><?= htmlspecialchars($article->title) ?></h2>
                    <p>
                        <?= htmlspecialchars($article_obj->getProperLength($article->content)) ?>
                    </p>
                    <a href="article.php?id=<?php echo $article->id ?>" class="btn btn-primary">Read More</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php
include "./partials/footer.php"
?>