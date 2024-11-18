<?php

// Query para buscar todos os dados da tabela
$sql = "SELECT id_disciplina, nome_disciplina FROM disciplina";
$result = $con->query($sql);

// Verificando se a consulta retornou resultados
if ($result->num_rows > 0) {
    // Gerar o select com as opções
    echo '<select name="item_id">';

    // Loop através das linhas retornadas
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id_disciplina'] . '">' . $row['nome_disciplina'] . '</option>';
    }

    echo '</select>';
} else {
    echo 'Nenhum item encontrado.';
}

// Fechar a conexão
$con->close();

?>