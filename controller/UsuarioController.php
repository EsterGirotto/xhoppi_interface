<?php
function loginUsuario($email, $senha)
{
    $email = limpar($email);
    $senha = limpar($senha);
    $resultado = mysqli_query(conectarBanco(), "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function redefinirSenha($email, $senha)
{
    $email = limpar($email);
    $senha = limpar($senha);
    mysqli_query(conectarBanco(), "UPDATE usuarios SET senha = '$senha' WHERE email = '$email'");

    if (mysqli_affected_rows(conectarBanco()) > 0) {
        return true;
    } else {
        return false;
    }
}

function exigirLogin()
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}
?>
