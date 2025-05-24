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
}
