<?php

class Funcionario
{
    // Atributos
    protected $nome;
    protected $sobrenome;
    protected $cpf;
    protected $dataNascimento;
    protected $telefone;
    protected $email;
    protected $senha;
    protected $cargo;
    protected $salario;

    // Construtor
    public function __construct($Nome, $Sobrenome, $Cpf, $DataNascimento, $Telefone, $Email, $Senha, $Cargo, $Salario)
    {
        $this->nome = $Nome;
        $this->sobrenome = $Sobrenome;
        $this->cpf = $Cpf;
        $this->dataNascimento = $DataNascimento;
        $this->telefone = $Telefone;
        $this->email = $Email;
        $this->senha = $Senha;
        $this->cargo = $Cargo;
        $this->salario = $Salario;
    }

    // Getter e Setter
    public function get_Nome() { return $this->nome; }
    public function set_Nome($Nome) { $this->nome = $Nome; }
    public function get_Sobrenome() { return $this->sobrenome; }
    public function set_Sobrenome($Sobrenome) { $this->sobrenome = $Sobrenome; }
    public function get_Cpf() { return $this->cpf; }
    public function set_Cpf($Cpf) { $this->cpf = $Cpf; }
    public function get_DataNascimento() { return $this->dataNascimento; }
    public function set_DataNascimento($DataNascimento) { $this->dataNascimento = $DataNascimento; }
    public function get_Telefone() { return $this->telefone; }
    public function set_Telefone($Telefone) { $this->telefone = $Telefone; }
    public function get_Email() { return $this->email; }
    public function set_Email($Email) { $this->email = $Email; }
    public function get_Senha() { return $this->senha; }
    public function set_Senha($Senha) { $this->senha = $Senha; }
    public function get_Cargo() { return $this->cargo; }
    public function set_Cargo($Cargo) { $this->cargo = $Cargo; }
    public function get_Salario() { return $this->salario; }
    public function set_Salario($Salario) { $this->salario = $Salario; }

    // Metodos
    public function aplicarAumento($Percentual)
    {
        $valorAumento = ($this->salario * $Percentual) / 100;
        $this->salario = $this->salario + $valorAumento;
    }
}

?>
