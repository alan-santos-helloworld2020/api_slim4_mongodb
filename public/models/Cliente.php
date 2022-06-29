<?php

namespace Teste\Models;

class Cliente{

    private $id;
    private $data;
    private $nome;
    private $telefone;
    private $email;
    private $cep;
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id 
	 * @return Cliente
	 */
	public function setId($id): self {
		$this->id = $id;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}
	
	/**
	 * @param mixed $data 
	 * @return Cliente
	 */
	public function setData($data): self {
		$this->data = $data;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getNome() {
		return $this->nome;
	}
	
	/**
	 * @param mixed $nome 
	 * @return Cliente
	 */
	public function setNome($nome): self {
		$this->nome = $nome;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getTelefone() {
		return $this->telefone;
	}
	
	/**
	 * @param mixed $telefone 
	 * @return Cliente
	 */
	public function setTelefone($telefone): self {
		$this->telefone = $telefone;
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
	 * @return Cliente
	 */
	public function setEmail($email): self {
		$this->email = $email;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCep() {
		return $this->cep;
	}
	
	/**
	 * @param mixed $cep 
	 * @return Cliente
	 */
	public function setCep($cep): self {
		$this->cep = $cep;
		return $this;
	}
}
