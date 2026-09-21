<?php

class Produto
{
    // Atributos
    protected $nome;
    protected $marca;
    protected $descricao;
    protected $valor;
    protected $quantidade;
    protected $imagem;

    // Construtor
    public function __construct($Nome, $Marca, $Descricao, $Valor, $Quantidade, $Imagem)
    {
        $this->nome = $Nome;
        $this->marca = $Marca;
        $this->descricao = $Descricao;
        $this->valor = $Valor;
        $this->quantidade = $Quantidade;
        $this->imagem = $Imagem;
    }

    // Getter e Setter
    public function get_Nome()
    {
        return $this->nome;
    }

    public function set_Nome($Nome)
    {
        $this->nome = $Nome;
    }

    public function get_Marca()
    {
        return $this->marca;
    }

    public function set_Marca($Marca)
    {
        $this->marca = $Marca;
    }

    public function get_Descricao()
    {
        return $this->descricao;
    }

    public function set_Descricao($Descricao)
    {
        $this->descricao = $Descricao;
    }

    public function get_Valor()
    {
        return $this->valor;
    }

    public function set_Valor($Valor)
    {
        $this->valor = $Valor;
    }

    public function get_Quantidade()
    {
        return $this->quantidade;
    }

    public function set_Quantidade($Quantidade)
    {
        $this->quantidade = $Quantidade;
    }

    public function get_Imagem()
    {
        return $this->imagem;
    }

    public function set_Imagem($Imagem)
    {
        $this->imagem = $Imagem;
    }

    // Metodos
    public function aplicarCupom($cupomTaxa)
    {
        $valorDesconto = ($this->valor * $cupomTaxa) / 100;
        $this->valor = $this->valor - $valorDesconto;
    }
}

?>
