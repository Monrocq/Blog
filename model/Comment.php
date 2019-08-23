<?php 

class Comment {
    
    private $_id;
    private $_article;
    private $_author;
    private $_date;
    private $_content;

    public function __construct($id, $article, $author, $date, $content) {
        $this->hydrate($id, $article, $author, $date, $content);
    }

    public function getId(){
		return $this->_id;
	}

	public function setId($_id){
		$this->_id = $_id;
	}

	public function getArticle(){
		return $this->_article;
	}

	public function setArticle($_article){
		$this->_article = $_article;
	}

	public function getAuthor(){
		return $this->_author;
	}

	public function setAuthor($_author){
		$this->_author = $_author;
	}

	public function getDate(){
		return $this->_date;
	}

	public function setDate($_date){
		$this->_date = $_date;
	}

	public function getContent(){
		return $this->_content;
	}

	public function setContent($_content){
		$this->_content = $_content;
    }
    
    public function hydrate($id, $article, $author, $date, $content) {
        $this->setId($id);
        $this->setArticle($article);
        $this->setAuthor($author);
        $this->setDate($date);
        $this->setContent($content);
	}
	
}