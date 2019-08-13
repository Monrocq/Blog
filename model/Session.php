<?php

class Session {

    private $db;
    private $_nickame;
    
    public function __construct($nickname, $mdp) {
        $this->db = new db;
        $this->hydrate($nickname);
        $connected = $this->connexion($nickname, $mdp);
        return $connected;
    }

    public function getNickname() {
        return $this->_nickname;
    }

    public function setNickname($nickname) {
        $this->_nickname = $nickname;
    }

    private function hydrate($nickname) {
        $this->setNickname($nickname);
    }

    private function connexion($nickname, $mdp) {
        $connexion = $this->db->req("SELECT password FROM users WHERE nickname = '$nickname'");
        $pwd = $connexion->fetch();
        if (password_verify($mdp, $pwd[0])) {
            $_SESSION['connected'] = true;
            $_SESSION['nickname'] = $this->getNickname();
            $connected = true;
        } else {
            $_SESSION['connected'] = false;
            $connected = false;
        }
        return $connected;
    }
}