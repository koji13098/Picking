<?php

require_once __DIR__ . '/../lib/mysqli.php';

$link = dbConnect();

$sqls = [
  <<<EOT
INSERT INTO forum (
  text
) VALUES (
  "サンプルデータですす"
);
EOT,
];

foreach ($sqls as $sql) {
  $result = mysqli_query($link, $sql);

  if ($result) {
    echo 'Query Done' . PHP_EOL;
  } else {
    echo mysqli_error($link);
  }
}

mysqli_close($link);
