<?php
require('conexao.php');
require('funcoes.php');

$idCliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
$idExemplar = filter_input(INPUT_POST, 'id_exemplar', FILTER_VALIDATE_INT);

if (!$idCliente || !$idExemplar) {
    exit('Dados inválidos!');
}

try {
    $pdo->beginTransaction();

    // Bloquear o cliente e o exemplar durante a operação
    $stmt = $pdo->prepare(
        "SELECT id_cliente FROM cliente
         WHERE id_cliente = ? FOR UPDATE"
    );
    $stmt->execute([$idCliente]);

    if (!$stmt->fetch()) {
        throw new Exception('Cliente não encontrado!');
    }

    $stmt = $pdo->prepare(
        "SELECT id_exemplar FROM exemplar
         WHERE id_exemplar = ? FOR UPDATE"
    );
    $stmt->execute([$idExemplar]);

    if (!$stmt->fetch()) {
        throw new Exception('Exemplar não encontrado!');
    }

    if (verificarAtrasos($pdo, $idCliente)) {
        throw new Exception('Cliente possui empréstimos atrasados!');
    }

    if (!verificarLimite($pdo, $idCliente)) {
        throw new Exception('Limite de 3 filmes atingido!');
    }

    if (!verificarDisponibilidade($pdo, $idExemplar)) {
        throw new Exception('Este filme não está disponível!');
    }

    // Buscar um funcionário ativo
    $stmt = $pdo->query(
        "SELECT id_funcionario FROM funcionario
         WHERE ativo = 1 LIMIT 1"
    );

    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$funcionario) {
        throw new Exception('Nenhum funcionário ativo encontrado!');
    }

    // Registrar locação
    $sql = "INSERT INTO locacao
            (id_cliente, id_funcionario,
             data_locacao, data_previsto_locacao, status)
            VALUES (?, ?, NOW(),
                    DATE_ADD(NOW(), INTERVAL 7 DAY), 'Ativa')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $idCliente,
        $funcionario['id_funcionario']
    ]);

    $idLocacao = $pdo->lastInsertId();

    // Associar o exemplar à locação
    $sql = "INSERT INTO item_locacao
            (id_locacao, id_exemplar, data_devolucao)
            VALUES (?, ?, NULL)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idLocacao, $idExemplar]);

    $pdo->commit();

    echo "Empréstimo realizado com sucesso!";
    echo '<p><a href="emprestimo.php">Voltar</a></p>';

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "Erro: " . htmlspecialchars($e->getMessage());
}
?>