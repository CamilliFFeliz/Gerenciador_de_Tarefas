<?php
require_once './database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $logado = Login($email, $senha);

    if ($logado) {
        echo "<script>alert('Login realizado com sucesso!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('E-mail ou senha inválidos!');</script>";
    }
}
?>

<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>
        <form id="login" method="post">
            <input id="email" name="email" type="email" placeholder="E-mail">
            <input id="senha" name="senha" type="password" placeholder="Senha">
            <input type="submit" value="Entrar">
        </form>
            <a href="?page=registrar">Registrar</a>
    </div>
</div>