<?php
require('conexao.php');

$titulo = filter_input(INPUT_POST, 'titulo');
$anoLancamento = filter_input(INPUT_POST, 'ano-lancamento', FILTER_SANITIZE_NUMBER_INT);
$duracao = filter_input(INPUT_POST, 'duracao', FILTER_SANITIZE_NUMBER_INT);
$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_NUMBER_INT);
$precoDiaria = filter_input(INPUT_POST, 'preco-diaria', FILTER_SANITIZE_NUMBER_FLOAT);

try {
  $sql = "INSERT INTO filme(titulo, ano_lancamento, duracao_min, preco_diaria, id_genero)
          VALUES('$titulo', '$anoLancamento', '$duracao', '$precoDiaria', '$genero')";
  $statement = $pdo -> query($sql);
  
  header('location:/');
  exit();
} catch(PDOException $e) {
  echo 'Erro ao cadastrar o filme: ' . $e -> getMessage();
  exit();
}
?>