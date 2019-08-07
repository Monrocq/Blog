<?php

class Post {

    private $_id;
    private $_title;
    private $_chapo;
    private $_content;
    private $_author;
    private $_dateadded;
    private $_lastupdated;

    public function __construct($id, $title, $chapo, $content, $author, $dateadded, $lastupdated) {
        $this->hydrate($id, $title, $chapo, $content, $author, $dateadded, $lastupdated);
    }

    public function getId(){
		return $this->_id;
	}

	public function setId($_id){
		$this->_id = $_id;
	}

	public function getTitle(){
		return $this->_title;
	}

	public function setTitle($_title){
		$this->_title = $_title;
	}

	public function getChapo(){
		return $this->_chapo;
	}

	public function setChapo($_chapo){
		$this->_chapo = $_chapo;
	}

	public function getContent(){
		return $this->_content;
	}

	public function setContent($_content){
		$this->_content = $_content;
	}

	public function getAuthor(){
		return $this->_author;
	}

	public function setAuthor($_author){
		$this->_author = $_author;
	}

	public function getDateAdded(){
		return $this->_dateadded;
	}

	public function setDateAdded($_dateadded){
		$this->_dateadded = $_dateadded;
	}

	public function getLastUpdated(){
		return $this->_lastupdated;
	}

	public function setLastUpdated($_lastupdated){
		$this->_lastupdated = $_lastupdated;
    }
    
    protected function hydrate($id, $title, $chapo, $content, $author, $dateadded, $lastupdated) {
        $this->setId($id);
        $this->setTitle($title);
        $this->setChapo($chapo);
        $this->setContent($content);
        $this->setAuthor($author);
        $this->setDateAdded($dateadded);
        $this->setLastUpdated($lastupdated);
    }
}