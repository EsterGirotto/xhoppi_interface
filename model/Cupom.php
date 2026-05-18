<?php
class Cupom
{
    private $codigo;
    private $descricao;
    private $desconto;
    private $validade;

    public function __construct($codigo, $descricao, $desconto, $validade)
    {
        $this->codigo = $codigo;
        $this->descricao = $descricao;
        $this->desconto = $desconto;
        $this->validade = $validade;
    }

    public function getCodigo() { return $this->codigo; }
    public function getDescricao() { return $this->descricao; }
    public function getDesconto() { return $this->desconto; }
    public function getValidade() { return $this->validade; }
}
?>
