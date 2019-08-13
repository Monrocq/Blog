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

}