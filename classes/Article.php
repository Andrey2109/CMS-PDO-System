<?php

class Article
{
    private $conn;
    private $table = 'articles';

    public function __construct()
    {
        $database = new Database;
        $this->conn = $database->getConnection();
    }

    public function getProperLength($content, $length = 100)
    {
        if (strlen($content) > $length) {
            return substr($content, 0, $length) . '...';
        } else {
            return $content;
        }
    }

    public function get_all()
    {
        $query = 'SELECT * FROM ' . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function get_article_by_id($id)
    {
        $query = 'SELECT * FROM ' . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_OBJ);
        if ($article) {
            return $article;
        }
        return false;
    }

    public function get_article_with_owner_by_id($id)
    {
        $query = 'SELECT 
                articles.id,
                articles.title,
                articles.content,
                articles.created_at,
                articles.image,
                users.id AS owner,
                users.username AS author,
                users.email AS author_email
         FROM ' . $this->table .
            " JOIN users ON articles.user_id = users.id" .
            " WHERE articles.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_OBJ);
        if ($article) {
            return $article;
        }
        return false;
    }

    public function getArticlesbyUser($id)
    {
        $query = 'SELECT 
                articles.id,
                articles.title,
                articles.content,
                articles.created_at,
                users.first_name AS first_name,
                users.last_name AS last_name
         FROM ' . $this->table .
            " JOIN users ON articles.user_id = users.id" .
            " WHERE articles.user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($article) {
            return $article;
        }
        return false;
    }

    public function formatCreatedAt($date)
    {
        return date('F j, Y', strtotime($date));
    }

    public function createArticle($title, $content, $image, $date, $id)
    {
        $query = 'INSERT INTO ' . $this->table .
            ' (title, content, image, created_at, user_id)' .
            ' VALUES (:title, :content, :image, :date, :id)';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        if ($result) {
            return true;
        }
        echo "Error happend during insertion operation";
        return false;
    }
    public function deleteArticle($id)
    {
        if (!empty($id)) {
            $query = "DELETE FROM " . $this->table . " WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            echo "Error happend during insertion operation";
            return false;
        } else {
            echo "No id found for the article";
        }
    }
    public function updateArticleById($id, $title, $content, $image, $date)
    {
        $query = 'UPDATE ' . $this->table .
            " SET title = :title, content = :content, image = :image, created_at = :date" .
            " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        if ($result) {
            return true;
        }
        echo "Error happened during update operation";
        return false;
    }

    public function generateDummyData($num = 10)
    {
        try {
            $this->conn->beginTransaction();
            $query = "INSERT INTO " . $this->table . " (title, content, user_id, created_at, image)
        VALUES  (:title, :content, :user_id, :created_at, :image)";

            $stmt = $this->conn->prepare($query);
            $dummy_titles = [
                "The Future of Web Development: Trends to Watch in 2025",
                "Building Scalable Applications with Modern PHP",
                "Understanding Database Design Principles",
                "Creating Responsive User Interfaces with CSS Grid",
                "JavaScript Frameworks: A Comprehensive Comparison",
                "Security Best Practices for Web Applications",
                "The Rise of AI in Software Development",
                "Performance Optimization Techniques for Websites",
                "Version Control Mastery: Git Tips and Tricks",
                "API Design Patterns for Modern Applications"
            ];

            $dummy_content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.";

            $dummy_image = 'https://picsum.photos/200/300';
            $user_id = 26;
            $created_at = date('Y-m-d H:i:s');

            for ($i = 0; $i < $num; $i++) {
                $title = $dummy_titles[array_rand($dummy_titles)];
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':content', $dummy_content);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':image', $dummy_image);
                $stmt->bindParam(':created_at', $created_at);
                $stmt->execute();
            }
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error during articles generation" . $e->getMessage();
            return false;
        }
    }
    public function reorderAndResetAutoIncrement()
    {
        try {

            $this->conn->beginTransaction();
            $query = "SELECT id FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $articles = $stmt->fetchAll(PDO::FETCH_OBJ);

            $newId = 1;
            foreach ($articles as $article) {
                $updateQuery = "UPDATE " . $this->table . " SET id = $newId WHERE id = :id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam('id', $article->id, PDO::PARAM_INT);
                $updateStmt->execute();
                $newId++;
            }
            $this->conn->commit();
            return true;
        } catch (Exception $exeption) {
            $this->conn->rollBack();
            throw $exeption;
        }
    }
}
