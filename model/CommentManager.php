<?php

class CommentManager {

    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    //Pour avoir le Nombre de commentaires afin de calculer le nombre de pages
    public function getNbComments($id) {
        $numbcomments = $this->db->prepare("SELECT COUNT(*) FROM comments WHERE post=?");
        $numbcomments->bindParam(1, $id, PDO::PARAM_INT);
        $numbcomments->execute();
        return $numbcomments->fetch();
    }

    //Récupére les commentaires et les transforme en objet
    public function getComments($post, $commentpage) {
        $offset = $commentpage * 5 - 5;
        $listing = $this->db->prepare(
            "SELECT comments.id, comments.author, comments.post, comments.content, comments.date_added, comments.last_maj, users.nickname 
            FROM comments JOIN users ON comments.author = users.id WHERE comments.post = :post AND validation = 1 GROUP BY id DESC LIMIT 5 OFFSET :offset");
        $listing->bindParam(':offset', $offset, PDO::PARAM_INT);
        $listing->bindParam(':post', $post, PDO::PARAM_STR);
        $listing->execute();
        $comments = array();
        foreach ($listing as $key => $dataRow) {
            if ($dataRow['last_maj'] !== null) {
                $date = $dataRow['last_maj'];
            } else {
                $date = $dataRow['date_added'];
            }
            $commentObject = new Comment(
                $dataRow['id'],
                $dataRow['post'],
                $dataRow['nickname'],
                $date,
                $dataRow['content']);
            $comments[] = $commentObject;
        }
        return $comments;
    }

    //Récupére les commentaires non approuvés
    public function getNoValidated() {
        $listing = $this->db->query(
            "SELECT comments.id, posts.title, comments.content, comments.date_added, comments.last_maj, users.nickname 
            FROM comments JOIN users ON comments.author = users.id JOIN posts ON comments.post = posts.id WHERE validation = 0");
        $comments = array();
        foreach ($listing as $key => $dataRow) {
            if ($dataRow['last_maj'] !== null) {
                $date = $dataRow['last_maj'];
            } else {
                $date = $dataRow['date_added'];
            }
            $commentObject = new Comment(
                $dataRow['id'],
                $dataRow['title'],
                $dataRow['nickname'],
                $date,
                $dataRow['content']);
            $comments[] = $commentObject;
        }
        return $comments;
    }

    //Pour les liens Ancre des modif' et suppr
    public function commentExists($comment, $id) {
        $commentExists = $this->db->prepare(
            "SELECT * FROM comments WHERE id=? AND post=?");
        $commentExists->bindParam(1, $comment, PDO::PARAM_INT);
        $commentExists->bindParam(2, $id, PDO::PARAM_INT);
        $commentExists->execute();
        return $commentExists;
    }

    //pour les liens Ancre des Ajouts
    public function lastComment($id) {
        $lastComment = $this->db->prepare(
            "SELECT id FROM comments WHERE post=:id ORDER BY id DESC");
        $lastComment->bindParam(':id', $id, PDO::PARAM_INT);
        $lastComment->execute();
        return $lastComment->fetch();
    }

    //Ajoute un commentaire
    public function addComment($post, $content) {
        $id = $_SESSION['id'];
        $reqadd = $this->db->prepare(
            "INSERT INTO comments(author, post, content, date_added) VALUES (:id, :post, :content, CURRENT_TIMESTAMP)");
        $reqadd->bindParam(':id', $id, PDO::PARAM_INT);
        $reqadd->bindParam(':post', $post, PDO::PARAM_INT);
        $reqadd->bindParam(':content', $content, PDO::PARAM_STR);
        $reqadd->execute();
        return $reqadd;
    }

    //Supprime un commentaire
    public function deleteComment($comment) {
        $reqdelete = $this->db->prepare(
            "DELETE FROM comments WHERE id=?");
        $reqdelete->bindParam(1, $comment, PDO::PARAM_INT);
        $reqdelete->execute();
        return $reqdelete;
    }

    //MAJ un commentaire
    public function updateComment($comment, $content) {
        $requpdate = $this->db->prepare(
            "UPDATE comments SET content=:content, last_maj=CURRENT_TIMESTAMP WHERE id=:comment");
        $requpdate->bindParam(':content', $content, PDO::PARAM_STR);
        $requpdate->bindParam(':comment', $comment, PDO::PARAM_INT);
        $requpdate->execute();
        return $requpdate;
    }

    //Approuve un commentaire
    public function validate($comment) {
        $approve = $this->db->prepare("UPDATE comments SET validation = 1 WHERE id=?");
        $approve->bindParam(1, $id, PDO::PARAM_INT);
        $approve->execute();
	}
}