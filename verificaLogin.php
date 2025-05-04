<?php
session_start();

if (!isset($_SESSION["idLogado"])) {
    $msg = urlencode("Você não está logado!");
    header("Location: index.php?page=home&msg=$msg");
    exit;
}
?>