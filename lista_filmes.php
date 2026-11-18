<?php
require('conexao.php');

try {
  $sql = "SELECT
              filme.id_filme,
              filme.titulo,
              COUNT(item_locacao.id_item) AS total_locacoes
          FROM
            filme
          INNER JOIN exemplar
              ON
            filme.id_filme = exemplar.id_filme
          INNER JOIN item_locacao
              ON
            exemplar.id_exemplar = item_locacao.id_exemplar
          GROUP BY
            filme.id_filme,
            filme.titulo
          ORDER BY
            total_locacoes DESC";
  $statement = $pdo -> query($sql);
  $resultado = $statement -> fetchAll(PDO::FETCH_ASSOC);

  header('Content-Type: text/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename="filmes_mais_alugados.csv"');

  $output = fopen('php://output', 'w');

  fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, [
  'Título',
  'Total de locações'
], ';');

  foreach($resultado as $filme) {
    fputcsv($output, [
      $filme['titulo'],
      $filme['total_locacoes']
    ], ';');
  }

  fclose($output);
  exit;
} catch(PDOException $e) {
  echo 'Erro ao fazer o download da lista de filmes: ' . $e -> getMessage();
  exit();
}
?>