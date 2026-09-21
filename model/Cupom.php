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
        $this->editarCupom($Codigo, $Descricao, $Desconto, $Validade);
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
    public function editarCupom($NovoCodigo, $NovaDescricao, $NovoDesconto, $NovaValidade)
    {
        $this->codigo = $NovoCodigo;
        $this->descricao = $NovaDescricao;
        $this->desconto = $NovoDesconto;
        $this->validade = $NovaValidade;
    }

    public function alterarDesconto($NovoDesconto)
    {
        $this->desconto = $NovoDesconto;
    }
}

?>
