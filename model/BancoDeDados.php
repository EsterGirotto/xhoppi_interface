<?php

class BancoDeDados
{
    private $host;
    private $usuario;
    private $senha;
    private $banco;

    public function __construct($host, $usuario, $senha, $banco)
    {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->banco = $banco;
    }

    public function conectarBD()
    {
        $conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->banco);

        if (!$conexao) {
            die('Erro ao conectar no banco de dados.');
        }

        mysqli_set_charset($conexao, 'utf8');
        return $conexao;
    }

    public function inserirCliente($cliente)
    {
        $conexao = $this->conectarBD();
        $nome = mysqli_real_escape_string($conexao, $cliente->get_Nome());
        $sobrenome = mysqli_real_escape_string($conexao, $cliente->get_Sobrenome());
        $cpf = mysqli_real_escape_string($conexao, $cliente->get_Cpf());
        $dataNascimento = mysqli_real_escape_string($conexao, $cliente->get_DataNascimento());
        $telefone = mysqli_real_escape_string($conexao, $cliente->get_Telefone());
        $email = mysqli_real_escape_string($conexao, $cliente->get_Email());
        $senha = mysqli_real_escape_string($conexao, $cliente->get_Senha());

        $consulta = "INSERT INTO clientes (nome, sobrenome, cpf, data_nascimento, telefone, email, senha)
                     VALUES ('$nome', '$sobrenome', '$cpf', '$dataNascimento', '$telefone', '$email', '$senha')";
        mysqli_query($conexao, $consulta);

        $consulta = "INSERT INTO usuarios (nome, email, senha, tipo)
                     VALUES ('$nome', '$email', '$senha', 'cliente')";
        mysqli_query($conexao, $consulta);
    }

    public function inserirFuncionario($funcionario)
    {
        $conexao = $this->conectarBD();
        $nome = mysqli_real_escape_string($conexao, $funcionario->get_Nome());
        $sobrenome = mysqli_real_escape_string($conexao, $funcionario->get_Sobrenome());
        $cpf = mysqli_real_escape_string($conexao, $funcionario->get_Cpf());
        $dataNascimento = mysqli_real_escape_string($conexao, $funcionario->get_DataNascimento());
        $telefone = mysqli_real_escape_string($conexao, $funcionario->get_Telefone());
        $cargo = mysqli_real_escape_string($conexao, $funcionario->get_Cargo());
        $salario = mysqli_real_escape_string($conexao, $funcionario->get_Salario());
        $email = mysqli_real_escape_string($conexao, $funcionario->get_Email());
        $senha = mysqli_real_escape_string($conexao, $funcionario->get_Senha());

        $consulta = "INSERT INTO funcionarios (nome, sobrenome, cpf, data_nascimento, telefone, cargo, salario, email, senha)
                     VALUES ('$nome', '$sobrenome', '$cpf', '$dataNascimento', '$telefone', '$cargo', '$salario', '$email', '$senha')";
        mysqli_query($conexao, $consulta);

        $consulta = "INSERT INTO usuarios (nome, email, senha, tipo)
                     VALUES ('$nome', '$email', '$senha', 'funcionario')";
        mysqli_query($conexao, $consulta);
    }

    public function inserirProduto($produto)
    {
        $conexao = $this->conectarBD();
        $nome = mysqli_real_escape_string($conexao, $produto->get_Nome());
        $marca = mysqli_real_escape_string($conexao, $produto->get_Marca());
        $descricao = mysqli_real_escape_string($conexao, $produto->get_Descricao());
        $valor = mysqli_real_escape_string($conexao, $produto->get_Valor());
        $quantidade = mysqli_real_escape_string($conexao, $produto->get_Quantidade());
        $imagem = mysqli_real_escape_string($conexao, $produto->get_Imagem());

        $consulta = "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem)
                     VALUES ('$nome', '$marca', '$descricao', '$valor', '$quantidade', '$imagem')";
        mysqli_query($conexao, $consulta);
    }

    public function inserirLoja($loja)
    {
        $conexao = $this->conectarBD();
        $nome = mysqli_real_escape_string($conexao, $loja->get_Nome());
        $cnpj = mysqli_real_escape_string($conexao, $loja->get_Cnpj());
        $endereco = mysqli_real_escape_string($conexao, $loja->get_Endereco());
        $telefone = mysqli_real_escape_string($conexao, $loja->get_Telefone());

        $consulta = "INSERT INTO lojas (nome, cnpj, endereco, telefone)
                     VALUES ('$nome', '$cnpj', '$endereco', '$telefone')";
        mysqli_query($conexao, $consulta);
    }

    public function inserirCupom($cupom)
    {
        $conexao = $this->conectarBD();
        $codigo = mysqli_real_escape_string($conexao, $cupom->get_Codigo());
        $descricao = mysqli_real_escape_string($conexao, $cupom->get_Descricao());
        $desconto = mysqli_real_escape_string($conexao, $cupom->get_Desconto());
        $validade = mysqli_real_escape_string($conexao, $cupom->get_Validade());

        $consulta = "INSERT INTO cupons (codigo, descricao, desconto, validade)
                     VALUES ('$codigo', '$descricao', '$desconto', '$validade')";
        mysqli_query($conexao, $consulta);
    }

    public function alterarCupom($id, $cupom)
    {
        $conexao = $this->conectarBD();
        $id = (int)$id;
        $codigo = mysqli_real_escape_string($conexao, $cupom->get_Codigo());
        $descricao = mysqli_real_escape_string($conexao, $cupom->get_Descricao());
        $desconto = mysqli_real_escape_string($conexao, $cupom->get_Desconto());
        $validade = mysqli_real_escape_string($conexao, $cupom->get_Validade());

        $consulta = "UPDATE cupons
                     SET codigo = '$codigo', descricao = '$descricao', desconto = '$desconto', validade = '$validade'
                     WHERE id = $id";
        return mysqli_query($conexao, $consulta);
    }

    public function excluirCupom($id)
    {
        $conexao = $this->conectarBD();
        $id = (int)$id;
        return mysqli_query($conexao, "DELETE FROM cupons WHERE id = $id");
    }

    public function retornarClientes()
    {
        $conexao = $this->conectarBD();
        return mysqli_query($conexao, 'SELECT * FROM clientes ORDER BY id DESC');
    }

    public function retornarFuncionarios()
    {
        $conexao = $this->conectarBD();
        return mysqli_query($conexao, 'SELECT * FROM funcionarios ORDER BY id DESC');
    }

    public function retornarProdutos()
    {
        $conexao = $this->conectarBD();
        return mysqli_query($conexao, 'SELECT * FROM produtos ORDER BY id DESC');
    }

    public function retornarLojas()
    {
        $conexao = $this->conectarBD();
        return mysqli_query($conexao, 'SELECT * FROM lojas ORDER BY id DESC');
    }

    public function retornarCupons()
    {
        $conexao = $this->conectarBD();
        return mysqli_query($conexao, 'SELECT * FROM cupons ORDER BY id DESC');
    }

    public function retornarProdutoPorId($id)
    {
        $conexao = $this->conectarBD();
        $id = (int)$id;
        $resultado = mysqli_query($conexao, "SELECT * FROM produtos WHERE id = $id");
        return mysqli_fetch_assoc($resultado);
    }

    public function autenticarUsuario($email, $senha)
    {
        $conexao = $this->conectarBD();
        $email = mysqli_real_escape_string($conexao, $email);
        $senha = mysqli_real_escape_string($conexao, $senha);
        $resultado = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
        return mysqli_fetch_assoc($resultado);
    }

    public function redefinirSenha($email, $senha)
    {
        $conexao = $this->conectarBD();
        $email = mysqli_real_escape_string($conexao, $email);
        $senha = mysqli_real_escape_string($conexao, $senha);
        mysqli_query($conexao, "UPDATE usuarios SET senha = '$senha' WHERE email = '$email'");
        return mysqli_affected_rows($conexao) > 0;
    }
}

?>
