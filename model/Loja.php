<?php
class Loja
{
    private $nome;
    private $cnpj;
    private $endereco;
    private $telefone;

    public function __construct($nome, $cnpj, $endereco, $telefone)
    {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
    }

    public function getNome() { return $this->nome; }
    public function getCnpj() { return $this->cnpj; }
    public function getEndereco() { return $this->endereco; }
    public function getTelefone() { return $this->telefone; }
}
?>
