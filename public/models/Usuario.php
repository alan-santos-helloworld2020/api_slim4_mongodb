<?php

namespace Teste\Models;


class Usuario{
    private $username;
    private $email;
    private $password;
	/**
	 * @return mixed
	 */
	public function getUsername() {
		return $this->username;
	}
	
	/**
	 * @param mixed $username 
	 * @return User
	 */
	public function setUsername($username): self {
		$this->username = $username;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * @param mixed $email 
	 * @return User
	 */
	public function setEmail($email): self {
		$this->email = $email;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * @param mixed $password 
	 * @return User
	 */
	public function setPassword($password): self {
		$this->password = $password;
		return $this;
	}
}