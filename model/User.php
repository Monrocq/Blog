<?php

//Permet de mettre les Utilisateurs sous forme d'objet pour plus facilement les manipuler dans le BO

class User {

	private $_id;
    private $_name;
    private $_firstname;
    private $_nickname;
    private $_email;
    private $_password;
    private $_lvl;
    private $_sign_up;
    private $_reset;

    public function __construct($id, $name, $fistname, $nickname, $email, $password, $lvl, $sign_up, $reset) {
        $this->hydrate($id, $name, $fistname, $nickname, $email, $password, $lvl, $sign_up, $reset);
	}
	
	public function getId(){
		return $this->_id;
	}

	public function setId($_id){
		$this->_id = $_id;
	}


    public function getName(){
		return $this->_name;
	}

	public function setName($_name){
		$this->_name = $_name;
	}

	public function getFirstname(){
		return $this->_firstname;
	}

	public function setFirstname($_firstname){
		$this->_firstname = $_firstname;
	}

	public function getNickname(){
		return $this->_nickname;
	}

	public function setNickname($_nickname){
		$this->_nickname = $_nickname;
	}

	public function getEmail(){
		return $this->_email;
	}

	public function setEmail($_email){
		$this->_email = $_email;
	}

	public function getPassword(){
		return $this->_password;
	}

	public function setPassword($_password){
		$this->_password = $_password;
	}

	public function getLvl(){
		return $this->_lvl;
	}

	public function setLvl($_lvl){
		$this->_lvl = $_lvl;
	}

	public function getSign_up(){
		return $this->_sign_up;
	}

	public function setSignUp($_sign_up){
		$this->_sign_up = $_sign_up;
	}

	public function getReset(){
		return $this->_reset;
	}

	public function setReset($_reset){
		$this->_reset = $_reset;
	}

	private function hydrate($id, $name, $fistname, $nickname, $email, $password, $lvl, $sign_up, $reset) {
		$this->setId($id);
		$this->setName($name);
		$this->setFirstname($fistname);
		$this->setNickname($nickname);
		$this->setEmail($email);
		$this->setPassword($password);
		$this->setLvl($lvl);
		$this->setSignUp($sign_up);
		$this->setReset($reset);
	}
}