<?php

class PostManager {

    private $db;

    public function __construct() {
        $this->db = new db;
    }

    public function getList ($page) {
        $offset = $page * 5 - 5;
        $list = $this->db->req('SELECT * FROM posts LIMIT 5 OFFSET '.$offset);
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

    public function getNbComments($id) {
        $numbcomments = $this->db->req("SELECT COUNT(*) FROM comments WHERE post=$id");
        return $numbcomments->fetch();
    }

    public function getArticle ($id) {
        $req = $this->db->req(
            "SELECT posts.id, posts.title, posts.chapo, posts.content, posts.date_added, posts.last_updated, users.nickname 
            FROM posts JOIN users ON posts.author = users.id WHERE posts.id = $id");
        $article = $req->fetch();
        $obj = new Post(
            $article['id'],
            $article['title'],
            $article['chapo'],
            $article['content'],
            $article['nickname'],
            $article['date_added'],
            $article['last_updated']);
        return $obj;
    }

    public function getComments($post, $commentpage) {
        $offset = $commentpage * 5 - 5;
        $listing = $this->db->req(
            "SELECT comments.id, comments.author, comments.post, comments.content, comments.date_added, comments.last_maj, users.nickname 
            FROM comments JOIN users ON comments.author = users.id WHERE comments.post = $post LIMIT 5 OFFSET $offset");
        $comments = array();
        foreach ($listing as $key => $dataRow) {
            $commentObject = new Comment(
                $dataRow['id'],
                $dataRow['post'],
                $dataRow['nickname'],
                $dataRow['date_added'],
                $dataRow['content']);
            $comments[] = $commentObject;
        }
        return $comments;
    }

    //Pour les liens Ancre des modif' et suppr
    public function commentExists($comment) {
        $commentExists = $this->db->req(
            "SELECT * FROM comments WHERE id=$comment");
        return $commentExists;
    }

    //pour les liens Ancre des Ajouts
    public function lastComment($id) {
        $lastComment = $this->db->req(
            "SELECT id FROM comments WHERE post=$id ORDER BY id DESC");
        return $lastComment->fetch();
    }

    public function addComment($post, $content) {
        $reqadd = $this->db->req(
            "INSERT INTO comments(author, post, content, date_added) VALUES (1, $post, '$content', CURRENT_TIMESTAMP)");
        return $reqadd;
    }

    public function deleteComment($comment) {
        $reqdelete = $this->db->req(
            "DELETE FROM comments WHERE id=$comment");
        return $reqdelete;
    }

    public function updateComment($comment, $content) {
        $requpdate = $this->db->req(
            "UPDATE comments SET content='$content' WHERE id=$comment");
        return $requpdate;
    }

}