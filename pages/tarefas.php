<?php
include "./database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = $_POST["titulo"] ?? null;
    $idResponsavel = $_POST["idResponsavel"] ?? null;
    $descricao = $_POST["descricao"] ?? null;
    $dataLimite = $_POST["dataLimite"] ?? null;
    $status = $_POST["status"] ?? null;

    if (isset($titulo, $idResponsavel, $descricao, $dataLimite, $status)) {
        $resultado = criarTarefa($titulo, $descricao, $dataLimite, $idResponsavel, $status);
        if ($resultado) {
            echo "<script>alert('Tarefa criada com sucesso!');</script>";
            unset($_POST["titulo"], $_POST["idResponsavel"], $_POST["descricao"], $_POST["dataLimite"], $_POST["status"]);
            unset($titulo, $idResponsavel, $descricao, $dataLimite, $status);
        } else {
            echo "<script>alert('Erro ao criar tarefa.');</script>";
        }
    }

    header("Location: " . $_SERVER["REQUEST_URI"]);
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
                    <th>Descrição</th>
                    <th>Data Limite</th>
                    <th>Comentários</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tarefas = listarTarefas(null, null, null);
                if (!empty($tarefas)) {
                    foreach ($tarefas as $tarefa) {
                        echo "<tr>";
                        echo "<td>{$tarefa['titulo']}</td>";
                        echo "<td>{$tarefa['idResponsavel']}</td>";
                        echo "<td>{$tarefa['status']}</td>";
                        echo "<td>{$tarefa['descricao']}</td>";
                        echo "<td>{$tarefa['dataLimite']}</td>";
                        echo "<td>" . ContarComentarios($tarefa['id']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhuma tarefa criada ainda.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <button type="submit"></button>
    <div class="criar-tarefa">
        <h3>Gerenciador de Tarefas</h3>
        <form action="" method="POST">
            <input type="text" name="titulo" id="titulo" placeholder="Título da Tarefa" required><br>
            <input type="text" name="descricao" id="descricao" placeholder="Descrição da Tarefa" required><br>


            <label for="idResponsavel">Responsável:</label><br>
            <select name="idResponsavel" id="idResponsavel" required>
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
            <label for="dataLimite">Data Limite:</label><br>
            <input type="date" name="dataLimite" id="data" placeholder="Data Limite"><br>

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