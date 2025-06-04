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
    <div class="d-flex justify-content-between align-items-center mb-4">

        <form class="d-flex align-items-center" action="<?= baseUrl('create_dummy_data.php') ?>" method="POST">
            <label class="form-label" for="ArticleCount">Number of articles</label>
            <input id="ArticleCount" style="width: 70px; margin: 0 10px" class="form-control" name="article_count" type="number" min="0" />
            <button class="btn btn-primary " type="submit">Generate Articles</button>
        </form>

        <form action="<?= baseUrl('reorder_articles.php') ?>" method="POST">
            <button name="reorder_articles" class="btn btn-warning" type="submit">Reorder Article ID's</button>
        </form>

        <button id="deleteSelectedBtn" class="btn btn-danger">Delete Selected Articles</button>

    </div>


    <!-- Articles Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle table-margin">
            <thead class="table-dark">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Excerpt</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Ajax Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_articles as $article): ?>
                    <tr>
                        <td><input type="checkbox" class="articleCheckbox" value="<?= $article->id ?>"></td>
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
                        <td>
                            <button data-id="<?= $article->id ?>" style="white-space: nowrap;" type="submit" class="btn btn-sm btn-danger delete-single">Ajax Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- <div class="table-margin"></div> -->
</main>

<script>
    document.getElementById('selectAll').onclick = function() {
        let checkboxes = document.querySelectorAll('.articleCheckbox')
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
    document.getElementById('deleteSelectedBtn').onclick = function() {
        let checkboxes = document.querySelectorAll('.articleCheckbox:checked')
        let checkBoxesIds = [];
        checkboxes.forEach((checkbox) => {
            checkBoxesIds.push(checkbox.value)
        })

        if (checkBoxesIds.length == 0) {
            alert('Select at least 1 article')
            return;
        }

        if (confirm('Are you sure you want to delete this article?')) {
            sendDeleteRequest(checkBoxesIds)
        }




    }
    document.querySelectorAll('.delete-single').forEach((button) => {
        button.onclick = function() {
            let articleId = this.getAttribute('data-id')
            if (confirm('Are you sure you want to delete article' + articleId + '?')) {
                sendDeleteRequest(articleId)
            }
        }
    })

    function sendDeleteRequest(Ids) {
        let xhr = new XMLHttpRequest;
        xhr.open('POST', '<?= baseUrl('delete-articles.php') ?>')
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText)

                if (response.success) {
                    alert('We did it and articles got deleted')
                } else {
                    alert('Failed delete the article' + response.message)
                }
            }
        }
        xhr.send(JSON.stringify({
            articleIds: Ids
        }))
    }
</script>


<?php
include "./partials/admin/footer.php";

?>