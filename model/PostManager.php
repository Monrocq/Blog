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
        $nb = $this->db->req('SELECT COUNT(*) FROM posts');
        return $nb->fetch();
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

    public function getComments($post) {
        $listing = $this->db->req(
            "SELECT comments.id, comments.author, comments.post, comments.content, comments.date_added, comments.last_maj, users.nickname 
            FROM comments JOIN users ON comments.author = users.id WHERE comments.post = $post");
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

}