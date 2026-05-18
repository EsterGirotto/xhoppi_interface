<?php
class Funcionario
{
    private $nome;
    private $sobrenome;
    private $cpf;
    private $dataNascimento;
    private $telefone;
    private $email;
    private $senha;
    private $cargo;
    private $salario;

    public function __construct($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha, $cargo, $salario)
    {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
        $this->cargo = $cargo;
        $this->salario = $salario;
    }

    public function getNome() { return $this->nome; }
    public function getSobrenome() { return $this->sobrenome; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getTelefone() { return $this->telefone; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
    public function getCargo() { return $this->cargo; }
    public function getSalario() { return $this->salario; }
}
?>
