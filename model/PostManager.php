<?php

class PostManager {

    private $db;

    public function __construct() {
        $this->db = new db;
    }

    public function getList ($page) {
        $offset = $page * 5 - 5;
        $list = $this->db->req('SELECT * FROM posts ORDER BY id DESC LIMIT 5 OFFSET '.$offset);
        $listPost = array();
        foreach ($list as $key => $dataRow) {
            $postObject = new Post(
                $dataRow['id'], 
                $dataRow['title'], 
                $dataRow['chapo'], 
                $dataRow['content'], 
                $dataRow['author'], 
                $dataRow['date_added'], 
                $dataRow['last_updated']);
            $listPost[] = $postObject;
        }
        return $listPost;
    }

    public function getNbArticles () {
        $numbarticles = $this->db->req('SELECT COUNT(*) FROM posts');
        return $numbarticles->fetch();
    }

    public function getArticle ($id) {
        $req = $this->db->req(
            "SELECT posts.id, posts.title, posts.chapo, posts.content, posts.date_added, posts.last_updated, users.nickname 
            FROM posts JOIN users ON posts.author = users.id WHERE posts.id = $id");
        $article = $req->fetch();
        $commentMapper = new CommentManager;
        $nbcomments = $commentMapper->getNbComments($id);
        $obj = new Post(
            $article['id'],
            $article['title'],
            $article['chapo'],
            $article['content'],
            $article['nickname'],
            $article['date_added'],
            $article['last_updated'],
            $nbcomments);
        return $obj;
    }

    public function addArticle($title, $chapo, $content, $id) {
        $add = $this->db->req(
            "INSERT INTO posts(title, chapo, content, author, date_added) VALUES ('$title', '$chapo', '$content', $id, CURRENT_TIMESTAMP)");
        if ($add == false) {
            return false;
        } else {
        $last = $this->getList(1);
        return $last[0];
        }
    }

    public function deleteArticle($article) {
        $this->db->req(
            "DELETE FROM posts WHERE id=$article");
    }

    public function updateArticle($title, $chapo, $content, $id) {
        $this->db->req(
            "UPDATE posts SET title='$title', chapo='$chapo', content='$content', last_updated=CURRENT_TIMESTAMP WHERE id=$id"
        );
    }

}
