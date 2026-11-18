<?php
require('conexao.php');
require('funcoes.php');

$clientes = $pdo->query("SELECT * FROM cliente")
                ->fetchAll(PDO::FETCH_ASSOC);

$idCliente = filter_input(INPUT_GET, 'id_cliente', FILTER_VALIDATE_INT);

$historico = [];

if ($idCliente) {
    $historico = buscarHistorico($pdo, $idCliente);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Empréstimos</title>
</head>
<body>

<h1>Histórico de Empréstimos</h1>

<form method="GET">

    <label>Selecione o cliente:</label>

    <select name="id_cliente">
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?= $cliente['id_cliente'] ?>"
                <?= $idCliente == $cliente['id_cliente'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cliente['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Consultar</button>
</form>

<br>

<?php if ($idCliente): ?>

<table border="1" cellpadding="10">
    <tr>
        <th>Filme</th>
        <th>Data do empréstimo</th>
        <th>Previsão de devolução</th>
        <th>Data da devolução</th>
        <th>Situação</th>
    </tr>

    <?php foreach ($historico as $item): ?>
        <?php
        if ($item['status'] == 'Cancelada') {
            $situacao = 'Cancelada';
        } elseif ($item['data_devolucao'] != null) {
            $situacao = 'Devolvida';
        } elseif (strtotime($item['data_previsto_locacao']) < time()) {
            $situacao = 'Atrasada';
        } else {
            $situacao = 'Ativa';
        }
        ?>
        <tr>
            <td><?= htmlspecialchars($item['titulo']) ?></td>
            <td><?= $item['data_locacao'] ?></td>
            <td><?= $item['data_previsto_locacao'] ?></td>
            <td><?= $item['data_devolucao'] ?? 'Pendente' ?></td>
            <td><?= $situacao ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($historico)): ?>
    <p>Este cliente não possui empréstimos.</p>
<?php endif; ?>

<?php endif; ?>

<p><a href="emprestimo.php">Voltar</a></p>

</body>
</html>