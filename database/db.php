<?php
session_start([
    'name' => "session",
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

if (!isset($_COOKIE["usuarios"])) {

    $usuarios = [$admin];
    setcookie("usuarios", json_encode($usuarios), 0, "/");
} else {

    $usuarios = json_decode($_COOKIE["usuarios"], true);


    $adminExists = false;
    foreach ($usuarios as $usuario) {
        if ($usuario["email"] === $admin["email"]) {
            $adminExists = true;
            break;
        }
    }

    if (!$adminExists) {
        $usuarios[] = $admin;
        setcookie("usuarios", json_encode($usuarios),  0, "/");
    }
}

if (!isset($_COOKIE["tarefas"])) {
    setcookie("tarefas", json_encode([]), 0, "/");
}

if (!isset($_COOKIE["comentarios"])) {
    setcookie("comentarios", json_encode([]), 0, "/");
}

function Registrar($nome, $email, $senha): bool
{
    if (isset($nome, $email, $senha)) {
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

        $usuariosJson = json_encode($usuarios);
        setcookie("usuarios", $usuariosJson, 0, "/");

        return true;
    }

    return false;
}

function Login($email, $senha): bool
{
    if (isset($email, $senha)) {

        $usuarios = json_decode($_COOKIE["usuarios"], true);
        foreach ($usuarios as $usuario) {

            if ($usuario["email"] == $email && $usuario["senha"] == $senha) {
                return true;
            }
        }
    }

    return false;
}

function Logout(): bool
{
    if (isset($_SESSION["session"])) {
        unset($_SESSION["session"]);
        session_destroy();
        return true;
    }
    return false;
}

function GetUsuario($idUsuario)
{
    $usuarios = json_decode($_COOKIE["usuarios"], true);
    foreach ($usuarios as $usuario) {
        if ($usuario["id"] = $idUsuario) {
            return $usuario;
        }
    }
}

function criarTarefa($titulo, $descricao, $dataLimite, $responsavel, $status = "pendente"): bool
{
    if (isset($titulo, $descricao, $dataLimite, $responsavel)) {
        $tarefa = [
            "id" => rand(1, 1000),
            "idResponsavel" => $responsavel,
            "titulo" => $titulo,
            "descricao" => $descricao,
            "dataLimite" => $dataLimite,
            "status" => $status,
            "dataCriacao" => date("Y-m-d H:i:s"),
        ];

        $tarefas = json_decode($_COOKIE["tarefas"], true) ?? [];
        array_push($tarefas, $tarefa);

        $tarefasJson = json_encode($tarefas);
        setcookie("tarefas", $tarefasJson, 0, "/");

        return true;
    }

    return false;
}

function listarTarefas($idResponsavel = null, $status = null, $dataLimite = null): array
{
    $tarefas = json_decode($_COOKIE["tarefas"], true) ?? [];


    $tarefasFiltradas = array_filter($tarefas, function ($tarefa) use ($idResponsavel, $status, $dataLimite) {
        return ($idResponsavel === null || $tarefa["idResponsavel"] == $idResponsavel) &&
            ($status === null || $tarefa["status"] == $status) &&
            ($dataLimite === null || $tarefa["dataLimite"] == $dataLimite);
    });

    return $tarefasFiltradas;
}

function deletarTarefa($idTarefa): bool
{
    if (isset($idTarefa)) {
        $tarefas = json_decode($_COOKIE["tarefas"], true);
        foreach ($tarefas as $key => $tarefa) {
            if ($tarefa["id"] == $idTarefa) {
                unset($tarefas[$key]);
                break;
            }
        }
        $tarefasJson = json_encode($tarefas, true);
        setcookie("tarefas", $tarefasJson, 0, "/");
        return true;
    }

    return false;
}

function criarComentario($idTarefa, $comentario)
{
    if (isset($idTarefa, $comentario)) {
        $comentario = [
            "id" => rand(1, 100),
            "idTarefa" => $idTarefa,
            "Idusuario" => $_SESSION["session"],
            "comentario" => $comentario,
            "data" => date("Y-m-d H:i:s"),

        ];
    }
}

function ListarComentarios($idTarefa): array
{
    $comentariosTarefa = [];
    if (isset($idTarefa)) {
        $comentarios = json_decode($_COOKIE["comentarios"], true) ?? [];
        foreach ($comentarios as $comentario) {
            if ($comentario["idTarefa"] == $idTarefa) {
                $comentariosTarefa[] = $comentario;
            }
        }
    }

    return  $comentariosTarefa;
}

function ContarComentarios($idTarefa): int
{
    $comentarios = ListarComentarios($idTarefa);
    return count($comentarios);
}
