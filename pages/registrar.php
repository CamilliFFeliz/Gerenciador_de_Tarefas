<?php
require_once './database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $registrado = Registrar($nome, $email, $senha);

    if ($registrado) {
        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        echo "<script>window.location.href = 'index.php?page=login';</script>";
    }
}
?>

<div class="login-container">
    <div class="login-box">
        <h2>Cadastro</h2>
        <form method="post">
            <input name="nome" type="text" placeholder="Nome">
            <input name="email" type="email" placeholder="E-mail">
            <input name="senha" type="password" placeholder="Senha">
            <input type="submit" value="Registrar">
        </form>
    </div>
</div>