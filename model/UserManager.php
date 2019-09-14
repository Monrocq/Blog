<?php

class UserManager {

    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    //Récupere sous forme de liste les utilisateurs
    public function listUsers() {
        $list = array();
        $list['Visiteurs (accès restreint)'] = $this->listVisitors();
        $list['Membres'] = $this->listMembers();
        $list['Modérateurs'] = $this->listModos();
        $list['Administrateurs'] = $this->listAdmins();
        return $list;
    }

    //Lvl->0
    public function listVisitors() {
        $users = $this->db->query("SELECT * FROM users WHERE lvl = '0' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    //Lvl->1
    public function listMembers() {
        $users = $this->db->query("SELECT * FROM users WHERE lvl = '1' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    //Lvl->2
    public function listModos() {
        $users = $this->db->query("SELECT * FROM users WHERE lvl = '2' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    //Lvl->3
    public function listAdmins() {
        $users = $this->db->query("SELECT * FROM users WHERE lvl = '3' ORDER BY nickname")->fetchall();
        return $this->usersInObject($users);
    }

    //Transforme les users in Object
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

    //Change le rôle d'un utilisateur
    public function change($role, $user) {
        $newLvl = $this->db->prepare("UPDATE users SET lvl = :role WHERE id = :user");
        $newLvl->bindParam(':role', $role, PDO::PARAM_STR);
        $newLvl->bindParam(':user', $user, PDO::PARAM_INT);
        $newLvl->execute();
    }

    //Vérifie si le mail d'un utilisateur existe déjà
    public function verifMail($email) {
        $verif = $this->db->prepare("SELECT * FROM users WHERE email=?")->fetch();
        return $verif->execute(array($email));
    }

    //Vérifie si le pseudo est déjà utilisé
    public function verifNick($nickname) {
        $verif = $this->db->query("SELECT * FROM users WHERE nickname=:nickname")->fetch();
        return $verif->execute(array(':nickname' => $nickname));
    }

    //Inscrits un visiteur
    public function registration($datatocheck, $filters, $hash) {
        $sanitizer  = new Waavi\Sanitizer\Sanitizer($datatocheck, $filters);
        $dataok = $sanitizer->sanitize();
        $firstname = $dataok['firstname'];
        $lastname = $dataok['lastname'];
        $nickname = $dataok['nickname'];
        $email = $dataok['email'];
        return $this->db->query("INSERT INTO users(name, firstname, nickname, email, password, lvl) VALUES ('$lastname', '$firstname', '$nickname', '$email', '$hash', '1')");
    }

    //Envoie le mail de réinitialisation
    public function forgot($twig, $email) {
        $exists = $this->db->prepare("SELECT * FROM users WHERE email = ?")->execute(array($email))->fetch();
        if ($exists == false) {
            return $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'unknown'));
        } else {
        $datetime = new DateTime;
        $datetime->setTimezone(new DateTimeZone('Europe/Paris'));
        $datetime->add(new DateInterval('PT02H03M27S'));
        $expiration = $datetime->format('Y-m-d H:i:s');
        $this->db->prepare("UPDATE users SET reset = :expiration WHERE email = :email ")->execute(array(':expiration' => $expiration, ':email' => $email));
        sendforgot($email, $expiration);
        return $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'known'));
        }
    }

    //Affiche la page de réinitialisation
    public function resetPwd($twig, $hashed, $key) {
        $name = $this->db->prepare("SELECT firstname, nickname FROM users WHERE password = ?")->execute(array($hashed))->fetch();
        $expiration = $db->query("SELECT reset FROM users WHERE nickname='{$name[1]}'")->fetch();
        if ((hash('sha256', $expiration[0]) == $key) && ($expiration[0] > date("Y-m-d H:i:s"))) {
            return $twig->render('reset.twig', array('hashed' => $hashed, 'name' => $name[0], 'state' => 'standby', 'nickname' => $name[1]));
        } else {
            return "Oups, ce lien n'est plus valide";
        }
    }

    //Récupére le mot de passe hashé correspondant à l'utilisateur
    public function backupPwd($nickname) {
        return $this->db->query("SELECT password FROM users WHERE nickname = ?")->execute(array($nickname))->fetch();
    }

    //Change le mot de passe
    public function boum($nickname, $confirm) {
        $newhashed = password_hash($confirm, PASSWORD_DEFAULT);
        return $this->db->prepare("UPDATE users SET password = :newhashed WHERE nickname = :nickname")->execute(array(':newhashed' => $newhashed, ':nickname' => $nickname));
    }
}