<?php

class UserManager {

    private $db;

    public function __construct() {
        $this->db = new db;
    }

    public function listUsers() {
        $list = array();
        $list['Visiteurs (accès restreint)'] = $this->listVisitors();
        $list['Membres'] = $this->listMembers();
        $list['Modérateurs'] = $this->listModos();
        $list['Administrateurs'] = $this->listAdmins();
        return $list;
    }

    public function listVisitors() {
        $users = $this->db->req("SELECT * FROM users WHERE lvl = '0' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    public function listMembers() {
        $users = $this->db->req("SELECT * FROM users WHERE lvl = '1' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    public function listModos() {
        $users = $this->db->req("SELECT * FROM users WHERE lvl = '2' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    public function listAdmins() {
        $users = $this->db->req("SELECT * FROM users WHERE lvl = '3' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    protected function usersInObject($users) {
        $group = array();
        foreach ($users as $key => $user) {
            $obj = new User(
                $user['id'],
                $user['name'],
                $user['firstname'],
                $user['nickname'],
                $user['email'],
                $user['password'],
                $user['lvl'],
                $user['sign_up'],
                $user['reset']
            );
            $group[] = $obj;
        }
        return $group;
    }

    public function change($role, $user) {
        $this->db->req("UPDATE users SET lvl = '$role' WHERE id = $user");
    }
}