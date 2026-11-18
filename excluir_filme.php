<?php
require('conexao.php');

$id = filter_input(INPUT_GET, 'id');

try {
  $sql = "DELETE FROM filme WHERE id_filme = $id";
  $statement = $pdo -> query($sql);
  header('location:/');
} catch(PDOException $e) {
  echo 'Erro ao excluir filme: ' . $e -> getMessage();
  exit();
}
?>