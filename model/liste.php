<?php

class liste {

    private $db;

    public function __construct() {
        $this->db = new db;
    }

    public function getList ($page) {
        $offset = $page * 5 - 5;
        $list = $this->db->req('SELECT title, chapo, last_maj, date_ajout FROM posts LIMIT 5 OFFSET '.$offset);
        return $list;
    }

    public function getNbArticles () {
        $nb = $this->db->req('SELECT COUNT(*) FROM posts');
        return $nb->fetch();
    }

}