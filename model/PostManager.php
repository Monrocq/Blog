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

}