<?php

class Loja
{
    // Atributos
    protected $nome;
    protected $cnpj;
    protected $endereco;
    protected $telefone;

    // Construtor
    public function __construct($Nome, $Cnpj, $Endereco, $Telefone)
    {
        $this->nome = $Nome;
        $this->cnpj = $Cnpj;
        $this->endereco = $Endereco;
        $this->telefone = $Telefone;
    }

    // Getter e Setter
    public function get_Nome() { return $this->nome; }
    public function set_Nome($Nome) { $this->nome = $Nome; }
    public function get_Cnpj() { return $this->cnpj; }
    public function set_Cnpj($Cnpj) { $this->cnpj = $Cnpj; }
    public function get_Endereco() { return $this->endereco; }
    public function set_Endereco($Endereco) { $this->endereco = $Endereco; }
    public function get_Telefone() { return $this->telefone; }
    public function set_Telefone($Telefone) { $this->telefone = $Telefone; }

    // Metodos
    public function alterarEndereco($NovoEndereco)
    {
        $this->endereco = $NovoEndereco;
    }
}

?>
