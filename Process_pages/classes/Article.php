<?php

require_once "Db.php";

class Article extends Db
{
    private $conn;

    public function __construct(){
        $this->conn = $this->connect();
    }


    public function insert_article($title, $category, $status, $excerpt, $content, $featured_image){
        try{
            $sql = "INSERT INTO articles(title, category, status, excerpt, content, featured_image) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$title, $category, $status, $excerpt, $content, $featured_image]);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function fetch_all_article(){
        try{
            $sql = "SELECT * FROM articles ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function fetch_articles_by_status($status){
        try{
            $sql = "SELECT * FROM articles WHERE status = ? ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$status]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function fetch_article_by_id($id){
        try{
            $sql = "SELECT * FROM articles WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function update_article($id, $title, $category, $status, $excerpt, $content, $featured_image){
        try{
            $sql = "UPDATE articles SET title = ?, category = ?, status = ?, excerpt = ?, content = ?, featured_image = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$title, $category, $status, $excerpt, $content, $featured_image, $id]);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function delete_article($id){
        try{
            $sql = "DELETE FROM articles WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$id]);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

}