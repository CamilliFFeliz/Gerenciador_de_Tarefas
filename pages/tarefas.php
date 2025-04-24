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