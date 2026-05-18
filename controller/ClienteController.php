<?php
function cadastrarCliente($dados)
{
    $cliente = new Cliente($dados['nome'], $dados['sobrenome'], $dados['cpf'], $dados['data_nascimento'], $dados['telefone'], $dados['email'], $dados['senha']);

    $nome = limpar($cliente->getNome());
    $sobrenome = limpar($cliente->getSobrenome());
    $cpf = limpar($cliente->getCpf());
    $dataNascimento = limpar($cliente->getDataNascimento());
    $telefone = limpar($cliente->getTelefone());
    $email = limpar($cliente->getEmail());
    $senha = limpar($cliente->getSenha());

    mysqli_query(conectarBanco(), "INSERT INTO clientes (nome, sobrenome, cpf, data_nascimento, telefone, email, senha) VALUES ('$nome', '$sobrenome', '$cpf', '$dataNascimento', '$telefone', '$email', '$senha')");
    mysqli_query(conectarBanco(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', 'cliente')");
}
?>