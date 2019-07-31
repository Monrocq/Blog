<?php

class liste {

    private $db;

    public function __construct() {

        $this->db = new db;

    }

    public function getList () {

        $list = $this->db->req('SELECT title, chapo, last_maj, date_ajout FROM posts');

        
        
        return $list;

    }

}