<?php
include "./database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"] ?? null;
    $comentario = $_POST["comentario"] ?? null;
    $responsavel = $_POST["responsavel"] ?? null;
    $dataLimite = $_POST["dataLimite"] ?? null;
    $status = $_POST["status"] ?? null;

    $resultado = criarTarefa($titulo, $comentario, $responsavel, $dataLimite, $status);
    if ($resultado) {
        echo "<script>alert('Tarefa criada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao criar tarefa.');</script>";
    }
}
?>

<div class="container-gerenciador">
    <div class="gerenciador">
        <h3>Quadro de Tarefas</h3>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Responsável</th>
                    <th>Status</th>
                    <th>Comentários</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['tarefas'])) {
                    foreach ($_SESSION['tarefas'] as $tarefa) {
                        echo "<tr>";
                        echo "<td>{$tarefa['titulo']}</td>";
                        echo "<td>{$tarefa['responsavel']}</td>";
                        echo "<td>{$tarefa['status']}</td>";
                        echo "<td>";
                        if (!empty($tarefa['comentarios'])) {
                            foreach ($tarefa['comentarios'] as $comentario) {
                                echo "<p><strong>{$comentario['usuario']}:</strong> {$comentario['comentario']}</p>";
                            }
                        } else {
                            echo "<p>Sem comentários</p>"; 
                        }
                        echo "</td>";
                        echo "<td><a href='editar_tarefa.php?id={$tarefa['id']}'>Editar</a> | <a href='deletar_tarefa.php?id={$tarefa['id']}'>Excluir</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma tarefa criada ainda.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="criar-tarefa">
        <h3>Gerenciador de Tarefas</h3>
            <form action="" method="POST">
                <input type="text" name="titulo" id="titulo" placeholder="Título da Tarefa" required><br>
                <input type="text" name="descricao" id="descricao" placeholder="Descrição da Tarefa" required><br>
                <input type="text" name="comentario" id="comentario" placeholder="Comentário/Descrição"><br>

                <label for="responsavel">Responsável:</label><br>
                <select name="responsavel" id="responsavel" required>
                    <option value="">Selecione o responsável</option>
                    <?php
                    if (isset($_COOKIE['usuarios'])) {
                        $usuarios = json_decode($_COOKIE['usuarios'], true);
                        foreach ($usuarios as $usuario) {
                            echo "<option value='" . htmlspecialchars($usuario['nome']) . "'>" . htmlspecialchars($usuario['nome']) . "</option>";
                        }
                    }
                    ?>
                </select><br>
                <input type="date" name="dataLimite" id="data"><br>
                <label for="status">Status:</label><br>
                <select name="status" id="status" required>
                    <option value="">Selecione o status</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Em Andamento">Em Andamento</option>
                    <option value="Concluída">Concluída</option>
                </select><br>
                <button type="submit" class="botao-criar">Criar Tarefa</button>
            </form>
    </div>
</div>
