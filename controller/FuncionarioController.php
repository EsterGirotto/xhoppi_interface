<?php
function cadastrarFuncionario($dados)
{
    $funcionario = new Funcionario($dados['nome'], $dados['sobrenome'], $dados['cpf'], $dados['data_nascimento'], $dados['telefone'], $dados['email'], $dados['senha'], $dados['cargo'], $dados['salario']);

    $nome = limpar($funcionario->getNome());
    $sobrenome = limpar($funcionario->getSobrenome());
    $cpf = limpar($funcionario->getCpf());
    $dataNascimento = limpar($funcionario->getDataNascimento());
    $telefone = limpar($funcionario->getTelefone());
    $cargo = limpar($funcionario->getCargo());
    $salario = limpar($funcionario->getSalario());
    $email = limpar($funcionario->getEmail());
    $senha = limpar($funcionario->getSenha());

    mysqli_query(conectarBanco(), "INSERT INTO funcionarios (nome, sobrenome, cpf, data_nascimento, telefone, cargo, salario, email, senha) VALUES ('$nome', '$sobrenome', '$cpf', '$dataNascimento', '$telefone', '$cargo', '$salario', '$email', '$senha')");
    mysqli_query(conectarBanco(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', 'funcionario')");
}
?>
