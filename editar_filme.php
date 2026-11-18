<?php
require('conexao.php');

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$titulo = filter_input(INPUT_POST, 'titulo');
$anoLancamento = filter_input(INPUT_POST, 'ano-lancamento', FILTER_SANITIZE_NUMBER_INT);
$duracao = filter_input(INPUT_POST, 'duracao', FILTER_SANITIZE_NUMBER_INT);
$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_NUMBER_INT);
$precoDiaria = filter_input(INPUT_POST, 'preco-diaria', FILTER_SANITIZE_NUMBER_FLOAT);

try {
  $sql = "UPDATE filme
          SET titulo = '$titulo',
          ano_lancamento = '$anoLancamento',
          duracao_min = '$duracao',
          preco_diaria = '$precoDiaria',
          id_genero = '$genero'
          WHERE id_filme = '$id'";
  $statement = $pdo -> query($sql);

  header('location:/');
} catch(PDOException $e) {
  echo 'Erro ao editar dados do filme: ' . $e -> getMessage();
  exit();
}
?>