<?php
include "./database/db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"] ?? null;
    $comentario = $_POST["comentario"] ?? null;
    $status = $_POST["status"] ?? null;

    $resultado = criarTarefa($titulo, $comentario, null, null, $status);
    if ($resultado) {
        echo "<script>alert('Tarefa criada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao criar tarefa.');</script>";
    }
}


?>

<h2>Painel de Tarefas</h2>
<div class="kanban-wrapper" id="kanbanWrapper">
    <div class="kanban-column">
        <h3>Iniciar</h3>
        <button class="add-task-btn" onclick="adicionarTarefa(this)">+ Adicionar Tarefa</button>
        <div class="task-list"></div>
        <br>
    </div>

    <div class="kanban-column">
        <h3>Em Andamento</h3>
        <button class="add-task-btn" onclick="adicionarTarefa(this)">+ Adicionar Tarefa</button>
        <div class="task-list"></div>
        <br>
    </div>

    <div class="kanban-column">
        <h3>Concluído</h3>
        <button class="add-task-btn" onclick="adicionarTarefa(this)">+ Adicionar Tarefa</button>
        <div class="task-list"></div>
    </div>
</div>

<form action="" method="post">
    <input type="text" name="">
    <button type="submit"></button>
</form>

<script>
    function adicionarTarefa(botao) {
        const container = botao.nextElementSibling;

        const card = document.createElement("div");
        card.className = "task-card";
        card.innerHTML = `
        <input type="text" placeholder="Título da Tarefa" class="task-title" />
        <textarea placeholder="Comentário..." class="task-comment"></textarea>
        <select class="task-status">
          <option>Pendente</option>
          <option>Em andamento</option>
          <option>Concluído</option>
        </select>
        <button class="delete-task" onclick="excluirTarefa(this)">🗑️ Excluir</button>
      `;
        container.appendChild(card);
    }

    function excluirTarefa(botao) {
        botao.parentElement.remove();
    }
</script>