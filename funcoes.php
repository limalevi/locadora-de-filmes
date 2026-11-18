<?php

// RN01: limite de 3 filmes por cliente
function verificarLimite($pdo, $idCliente) {
    $sql = "SELECT COUNT(*) FROM item_locacao i
            JOIN locacao l ON i.id_locacao = l.id_locacao
            WHERE l.id_cliente = :cliente
            AND i.data_devolucao IS NULL
            AND l.status IN ('Ativa', 'Atrasada')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cliente' => $idCliente]);

    return $stmt->fetchColumn() < 3;
}

// RN02: consultar histórico
function buscarHistorico($pdo, $idCliente) {
    $sql = "SELECT f.titulo, l.data_locacao,
                   l.data_previsto_locacao,
                   i.data_devolucao, l.status
            FROM locacao l
            JOIN item_locacao i ON l.id_locacao = i.id_locacao
            JOIN exemplar e ON i.id_exemplar = e.id_exemplar
            JOIN filme f ON e.id_filme = f.id_filme
            WHERE l.id_cliente = :cliente
            ORDER BY l.data_locacao DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cliente' => $idCliente]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// RN03: verificar atrasos
function verificarAtrasos($pdo, $idCliente) {
    $sql = "SELECT COUNT(*) FROM locacao l
            JOIN item_locacao i ON l.id_locacao = i.id_locacao
            WHERE l.id_cliente = :cliente
            AND l.data_previsto_locacao < NOW()
            AND i.data_devolucao IS NULL
            AND l.status IN ('Ativa', 'Atrasada')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cliente' => $idCliente]);

    return $stmt->fetchColumn() > 0;
}

// Verificar disponibilidade de um exemplar
function verificarDisponibilidade($pdo, $idExemplar) {
    $sql = "SELECT COUNT(*) FROM item_locacao i
            JOIN locacao l ON i.id_locacao = l.id_locacao
            WHERE i.id_exemplar = :exemplar
            AND i.data_devolucao IS NULL
            AND l.status IN ('Ativa', 'Atrasada')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['exemplar' => $idExemplar]);

    return $stmt->fetchColumn() == 0;
}
?>