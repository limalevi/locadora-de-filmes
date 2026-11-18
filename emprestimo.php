<?php
require('conexao.php');

$clientes = $pdo -> query("SELECT * FROM cliente") -> fetchAll(PDO::FETCH_ASSOC);

$filmes = $pdo -> query(
  "SELECT e.id_exemplar, f.titulo
     FROM exemplar e
     JOIN filme f ON e.id_filme = f.id_filme"
) -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Empréstimo de Filmes</title>
  <link rel="stylesheet" href="css/emprestimo.css">
</head>
<body>

<form action="add_emprestimo.php" method="POST">
  <h1>Realizar Empréstimo</h1>

  <div class="select-container">
    <label class="label">Cliente:</label>
    <select name="id_cliente" class="select" required>
      <?php foreach ($clientes as $cliente): ?>
        <option value="<?= $cliente['id_cliente'] ?>">
          <?= htmlspecialchars($cliente['nome']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="select-container">
    <label class="label">Filme:</label>
    <select name="id_exemplar" class="select" required>
      <?php foreach ($filmes as $filme): ?>
        <option value="<?= $filme['id_exemplar'] ?>">
          <?= htmlspecialchars($filme['titulo']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit" id="btn-emprestimo">Realizar empréstimo</button>
</form>

<div id="btn-container">
  <a href="index.php" id="btn-voltar">Voltar ao início</a>
  <a href="historico.php" id="btn-historico">Consultar histórico</a>
</div>

</body>
</html>