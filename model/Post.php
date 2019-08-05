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

    public function get_id(){
		return $this->_id;
	}

	public function set_id($_id){
		$this->_id = $_id;
	}

	public function get_title(){
		return $this->_title;
	}

	public function set_title($_title){
		$this->_title = $_title;
	}

	public function get_chapo(){
		return $this->_chapo;
	}

	public function set_chapo($_chapo){
		$this->_chapo = $_chapo;
	}

	public function get_content(){
		return $this->_content;
	}

	public function set_content($_content){
		$this->_content = $_content;
	}

	public function get_author(){
		return $this->_author;
	}

	public function set_author($_author){
		$this->_author = $_author;
	}

	public function get_dateadded(){
		return $this->_dateadded;
	}

	public function set_dateadded($_dateadded){
		$this->_dateadded = $_dateadded;
	}

	public function get_lastupdated(){
		return $this->_lastupdated;
	}

	public function set_lastupdated($_lastupdated){
		$this->_lastupdated = $_lastupdated;
    }
    
    protected function hydrate($id, $title, $chapo, $content, $author, $dateadded, $lastupdated) {
        $this->set_id($id);
        $this->set_title($title);
        $this->set_chapo($chapo);
        $this->set_content($content);
        $this->set_author($author);
        $this->set_dateadded($dateadded);
        $this->set_lastupdated($lastupdated);
    }
}