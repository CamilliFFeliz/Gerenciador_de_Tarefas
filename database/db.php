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
                $_SESSION["idLogado"] = $usuario["id"];
                return true;
            }
        }
    }

    return false;
}

function Logout(): bool
{
    if (isset($_SESSION["idLogado"])) {
        unset($_SESSION["idLogado"]);
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
    if (isset($tarefa, $titulo, $descricao, $dataLimite, $responsavel)) {
        $tarefa = [
            "id" => rand(1, 1000),
            "idResponsavel" => $responsavel,
            "titulo" => $titulo,
            "descricao" => $descricao,
            "dataLimite" => $dataLimite,
            "status" => $status,
            "dataCriacao" => date("Y-m-d H:i:s"),
        ];


        $tarefas = json_decode($_COOKIE["tarefas"], true);
        array_push($tarefas, $tarefa);

        $tarefasJson = json_encode($tarefas);
        setcookie("tarefas", $tarefasJson, 0, "/");

        return true;
    }

    return false;
}

function listarTarefas($idResponsavel = null, $status = null, $dataLimite = null): array
{
    $tarefas = json_decode($_COOKIE["tarefas"], true);

    // Filtra as tarefas com base nos parâmetros fornecidos
    $tarefasFiltradas = array_filter($tarefas, function ($tarefa) use ($idResponsavel, $status, $dataLimite) {
        return ($idResponsavel === null || $tarefa["idResponsavel"] == $idResponsavel) &&
            ($status === null || $tarefa["status"] == $status) &&
            ($dataLimite === null || $tarefa["dataLimite"] == $dataLimite);
    });

    return $tarefasFiltradas;
}

function DeletarTarefa($idTarefa): bool
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
            "Idusuario" => $_SESSION["idLogado"],
            "comentario" => $comentario,
            "data" => date("Y-m-d H:i:s"),

        ];
    }
}

function ListarComentarios($idTarefa): array
{
    $comentariosTarefa = [];
    if (isset($idTarefa)) {
        $comentarios = json_decode($_COOKIE["comentarios"], true);
        foreach ($comentarios as $comentario) {
            if ($comentario["idTarefa"] == $idTarefa) {
                $comentariosTarefa[] = $comentario;
            }
        }
    } 

    return  $comentariosTarefa;
}
