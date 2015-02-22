<?php

namespace Freshservice;

class LoginCredentials {

	// PRIVATE VARIABLES
	private $_username = null;
	private $_password = null;
	private $_apiKey = null;

	// DECLARE CONSTRUCTORS

	public static function authenticateWithUserCredentials($username, $password) {
		$instance = new self();
		$instance->setUsername($username);
		$instance->setUsername($password);
		return $instance;
	}

	public static function authenticateWithToken($apiKey) {
		$instance = new self();
		$instance->setApiKey($apiKey);
		return $instance;
	}

	public function getCurlLoginString() {
		if ($this->_apiKey == null) {
			return base64_encode($this->getUsername() . ":" . $this->getPassword());
		} else {
			return $this->getApiKey() . ":X";
		}
	}

	// GETTERS

	public function getApiKey() {
		return $this->_apiKey;
	}

	public function getUsername() {
		return $this->_username;
	}

	public function getPassword() {
		return $this->_password;
	}

	// SETTERS

	public function setApiKey($a) {
		$this->_apiKey = $a;
	}

	public function setUsername($a) {
		$this->_username = $a;
	}

	public function setPassword($a) {
		$this->_password = $a;
	}
    
}
