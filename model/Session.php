<?php

class Session {

    private $db;
    private $_nickame;
    
    public function __construct($nickname, $mdp) {
        $this->db = Db::getInstance();
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

    //Créer la session
    private function connexion($nickname, $mdp) {
        sleep(1);
        $connexion = $this->db->query("SELECT id, password, lvl FROM users WHERE nickname = '$nickname'");
        $pwd = $connexion->fetch();
        if (password_verify($mdp, $pwd[1])) {
            $_SESSION['connected'] = true;
            $_SESSION['nickname'] = $this->getNickname();
            $_SESSION['id'] = $pwd[0];
            $_SESSION['lvl'] = $pwd[2];
            $connected = true;
        } else {
            $_SESSION['connected'] = false;
            $connected = false;
        }
        return $connected;
    }
}