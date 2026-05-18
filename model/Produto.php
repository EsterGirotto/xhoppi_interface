<?php
class Produto
{
    private $nome;
    private $marca;
    private $descricao;
    private $valor;
    private $quantidade;
    private $imagem;

    public function __construct($nome, $marca, $descricao, $valor, $quantidade, $imagem)
    {
        $this->nome = $nome;
        $this->marca = $marca;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->quantidade = $quantidade;
        $this->imagem = $imagem;
    }

    public function getNome() { return $this->nome; }
    public function getMarca() { return $this->marca; }
    public function getDescricao() { return $this->descricao; }
    public function getValor() { return $this->valor; }
    public function getQuantidade() { return $this->quantidade; }
    public function getImagem() { return $this->imagem; }
    public function setValor($valor) { $this->valor = $valor; }
    public function atualizarValor($percentual) { $this->valor = $this->valor + ($this->valor * $percentual / 100); }
}
?>
