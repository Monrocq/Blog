<?php

class CommentManager {

    private $db;

    public function __construct() {
        $this->db = new db;
    }

    public function getNbComments($id) {
        $numbcomments = $this->db->req("SELECT COUNT(*) FROM comments WHERE post=$id");
        return $numbcomments->fetch();
    }

    public function getComments($post, $commentpage) {
        $offset = $commentpage * 5 - 5;
        $listing = $this->db->req(
            "SELECT comments.id, comments.author, comments.post, comments.content, comments.date_added, comments.last_maj, users.nickname 
            FROM comments JOIN users ON comments.author = users.id WHERE comments.post = $post AND validation = 1 GROUP BY id DESC LIMIT 5 OFFSET $offset");
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

    public function getNoValidated() {
        $listing = $this->db->req(
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
        $commentExists = $this->db->req(
            "SELECT * FROM comments WHERE id=$comment AND post=$id");
        return $commentExists;
    }

    //pour les liens Ancre des Ajouts
    public function lastComment($id) {
        $lastComment = $this->db->req(
            "SELECT id FROM comments WHERE post=$id ORDER BY id DESC");
        return $lastComment->fetch();
    }

    public function addComment($post, $content) {
        $id = $_SESSION['id'];
        $reqadd = $this->db->req(
            "INSERT INTO comments(author, post, content, date_added) VALUES ($id, $post, '$content', CURRENT_TIMESTAMP)");
        return $reqadd;
    }

    public function deleteComment($comment) {
        $reqdelete = $this->db->req(
            "DELETE FROM comments WHERE id=$comment");
        return $reqdelete;
    }

    public function updateComment($comment, $content) {
        $requpdate = $this->db->req(
            "UPDATE comments SET content='$content', last_maj=CURRENT_TIMESTAMP WHERE id=$comment");
        return $requpdate;
    }

    public function validate($comment) {
		$this->db->req("UPDATE comments SET validation = 1 WHERE id=$comment");
	}
}