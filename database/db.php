<?php
session_start([
    'name' => "idLogado",
    'cookie_lifetime' => 60 * 60 * 24,
    'cookie_path' => '/',
    'cookie_secure' => false,
]);

$usuarios = [];
$admin = [
    "id" => 0,
    "nome" => "admin",
    "email" => "admin@gmail.com",
    "senha" => "1234",
];
// Verifica se o cookie "usuarios" já existe
if (!isset($_COOKIE["usuarios"])) {
    // Se não existir, cria o array com o admin e define o cookie
    $usuarios = [$admin];
    setcookie("usuarios", json_encode($usuarios), 0, "/");
} else {
    // Se já existir, carrega os usuários existentes
    $usuarios = json_decode($_COOKIE["usuarios"], true);

    // Verifica se o admin já está no array
    $adminExists = false;
    foreach ($usuarios as $usuario) {
        if ($usuario["email"] === $admin["email"]) {
            $adminExists = true;
            break;
        }
    }

    // Se o admin não estiver no array, adiciona
    if (!$adminExists) {
        $usuarios[] = $admin;
        setcookie("usuarios", json_encode($usuarios),  0, "/");
    }
}

function Registrar($nome, $email, $senha) : bool
{
    if (isset($nome) && isset($email) && isset($senha)) {
        $usuarios = json_decode($_COOKIE["usuarios"], true);

        foreach ($usuarios as $usuario) {
            if ($usuario["email"] == $email) {
                return false;
            }
        }

        $user = [
            "id" => rand(1, 1000),
            "nome" => $nome,
            "email" => $email,
            "senha" => $senha,
        ];
        array_push($usuarios, $user);

        setcookie("usuarios", json_encode($usuarios), 0, "/");

        return true;
    }

    return false;
}

function Logar($email, $senha): bool {
    $usuarios = json_decode($_COOKIE["usuarios"], true);
    foreach ($usuarios as $usuario) {
        if ($usuario["email"] == $email && $usuario["senha"] == $senha) {
            $_SESSION["idLogado"] = $usuario["id"];
            return true;
        }
    }
    return false;
}
