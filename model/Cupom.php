<?php

class Cupom
{
    // Atributos
    protected $codigo;
    protected $descricao;
    protected $desconto;
    protected $validade;

    // Construtor
    public function __construct($Codigo, $Descricao, $Desconto, $Validade)
    {
        $this->codigo = $Codigo;
        $this->descricao = $Descricao;
        $this->desconto = $Desconto;
        $this->validade = $Validade;
    }

    // Getter e Setter
    public function get_Codigo() { return $this->codigo; }
    public function set_Codigo($Codigo) { $this->codigo = $Codigo; }
    public function get_Descricao() { return $this->descricao; }
    public function set_Descricao($Descricao) { $this->descricao = $Descricao; }
    public function get_Desconto() { return $this->desconto; }
    public function set_Desconto($Desconto) { $this->desconto = $Desconto; }
    public function get_Validade() { return $this->validade; }
    public function set_Validade($Validade) { $this->validade = $Validade; }

    // Metodos
    public function alterarDesconto($NovoDesconto)
    {
        $this->desconto = $NovoDesconto;
    }
}

?>
