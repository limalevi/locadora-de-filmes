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
  <title>Empréstimo de Filmes</title>
</head>
<body>

<h1>Realizar Empréstimo</h1>

<form action="add_emprestimo.php" method="POST">

  <label>Cliente:</label>

  <select name="id_cliente" required>
    <?php foreach ($clientes as $cliente): ?>
      <option value="<?= $cliente['id_cliente'] ?>">
        <?= htmlspecialchars($cliente['nome']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <br><br>

  <label>Filme:</label>

  <select name="id_exemplar" required>
    <?php foreach ($filmes as $filme): ?>
      <option value="<?= $filme['id_exemplar'] ?>">
        <?= htmlspecialchars($filme['titulo']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <br><br>

  <button type="submit">Realizar empréstimo</button>
</form>

<p><a href="historico.php">Consultar histórico</a></p>
<p><a href="index.php">Voltar ao início</a></p>

</body>
</html>