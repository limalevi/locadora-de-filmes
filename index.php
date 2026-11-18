<?php
require('conexao.php');

$sql = "SELECT f.id_filme, f.titulo, f.ano_lancamento, f.duracao_min, f.preco_diaria, g.id_genero, g.nome FROM filme AS f
        LEFT JOIN genero AS g
        ON f.id_genero = g.id_genero";
$statement = $pdo -> query($sql);
$resultado = $statement -> fetchAll(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="css/style.css">
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
        <a href="emprestimo.php" class="header-link">Empréstimos</a>
      </nav>
      
    </div>
  </header>
  <main>
    <form
      action="add_filme.php"
      method="POST"
      class="filme-form">

      <input
        type="text"
        name="titulo"
        class="txt-input"
        id="titulo"
        placeholder="Título"
        required>

      <input
        type="number"
        name="ano-lancamento"
        class="txt-input"
        id="ano-lancamento"
        placeholder="Ano de lançamento"
        min="0"
        max="9999"
        required>

      <input
        type="number"
        name="duracao"
        class="txt-input"
        id="duracao"
        placeholder="Duração (min)"
        min="0"
        max="999"
        required>

      <select name="genero" id="genero">
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
        min="0"
        max="99"
        step="0.01"
        required>

      <input
        type="submit"
        value="Cadastrar filme"
        id="btn-add-filme">

      <a href="lista_filmes.php">Baixar lista de filmes</a>
    </form>

    <table>
      <thead>
        <tr>
          <th colspan="6">Filmes</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <th>Título</th>
          <th>Ano de lançamento</th>
          <th>Duração</th>
          <th>Gênero</th>
          <th>Preço (diária)</th>
          <th>Ações</th>
        </tr>

        <?php foreach($resultado as $filme): ?>
          <tr>
            <td><?= $filme['titulo'] ?></td>
            <td><?= $filme['ano_lancamento'] ?></td>
            <td><?= "$filme[duracao_min] min" ?></td>
            <td><?= $filme['nome'] ?></td>
            <td><?= "$filme[preco_diaria] R$" ?></td>
            <td>
              <a href="edicao_filme.php?id=<?= $filme['id_filme'] ?>">Editar</a>
              <a href="excluir_filme.php?id=<?= $filme['id_filme'] ?>">Excluir</a>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>

    </table>
  </main>
</body>
</html>