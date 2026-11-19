<?php
require('conexao.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if(!$id) {
  exit('ID do filme inválido!');
}

try {
  $pdo -> beginTransaction();

  $sql = "SELECT COUNT(*)
          FROM exemplar e
          INNER JOIN item_locacao i
            ON e.id_exemplar = i.id_exemplar
          WHERE e.id_filme = ?";
  $statement = $pdo -> prepare($sql);
  $statement -> execute([$id]);
  $total = $statement -> fetchColumn();

  if($total > 0) {
    throw new Exception('Não é possível excluir este filme: existem registros de locação associados a ele.');
  }

  $sql = "DELETE FROM exemplar WHERE id_filme = ?";
  $statement = $pdo -> prepare($sql);
  $statement -> execute([$id]);
  
  $sql = "DELETE FROM filme WHERE id_filme = ?";
  $statement = $pdo -> prepare($sql);
  $statement -> execute([$id]);

  $pdo -> commit();

  header('location:/');
  exit();
} catch(Exception $e) {
  if($pdo -> inTransaction()) {
    $pdo -> rollBack();
  }
  echo 'Erro: ' . $e -> getMessage();
}
?>