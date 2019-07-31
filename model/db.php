<?php

class db {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=p5', 'root', '');
    }

    public function req($req) {
        $requete = $this->db->query($req);
        //$requete->setFetchMode(PDO::FETCH_OBJ);
        //$requete = $requete->fetch();
        return $requete;
    }

}