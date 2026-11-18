<?php
require('conexao.php');

$id = filter_input(INPUT_GET, 'id');
$sql = "SELECT id_filme, titulo, ano_lancamento, duracao_min, preco_diaria, f.id_genero, nome FROM filme AS f
        LEFT JOIN genero AS g
        ON f.id_genero = g.id_genero WHERE id_filme = $id";
$statement = $pdo -> query($sql);
$filme = $statement -> fetch(PDO::FETCH_ASSOC);

$sql_genero = "SELECT * FROM genero";
$statement_genero = $pdo -> query($sql_genero);
$generos = $statement_genero -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Locadora de Filmes</title>
  <link rel="stylesheet" href="css/edicao_filme.css">
</head>
<body>
  <header>
    <div id="header-container">
      <h1>Locadora de filmes</h1>

      <nav>
        <a href="index.php" class="header-link">Início</a>
        <a href="" class="header-link">Filmes</a>
        <a href="" class="header-link">Funcionários</a>
        <a href="" class="header-link">Clientes</a>
      </nav>

    </div>
  </header>
  <main>
    <form
      action="editar_filme.php"
      method="POST"
      class="filme-form">
    
      <input
        type="hidden"
        name="id"
        id="id"
        value="<?= $filme['id_filme'] ?>">

      <input
        type="text"
        name="titulo"
        class="txt-input"
        id="titulo"
        placeholder="Título"
        value="<?= $filme['titulo'] ?>"
        required>

      <input
        type="number"
        name="ano-lancamento"
        class="txt-input"
        id="ano-lancamento"
        placeholder="Ano de lançamento"
        value="<?= $filme['ano_lancamento'] ?>"
        min="0"
        max="9999"
        required>

      <input
        type="number"
        name="duracao"
        class="txt-input"
        id="duracao"
        placeholder="Duração (min)"
        value="<?= $filme['duracao_min'] ?>"
        min="0"
        max="999"
        required>

      <select
        name="genero"
        id="genero">
        <?php foreach($generos as $genero): ?>
          <option value="<?= $genero['id_genero'] ?>">
            <?= $genero['nome'] ?>
          </option>
        <?php endforeach ?>
      </select>

      <input
        type="number"
        name="preco-diaria"
        class="txt-input"
        id="preco-diaria"
        placeholder="Preço da diária"
        value="<?= $filme['preco_diaria'] ?>"
        min="0"
        max="99"
        step="0.01"
        required>

      <input
        type="submit"
        value="Editar filme"
        id="btn-editar-filme">
    </form>
  </main>
</body>
</html>