<?php

require_once __DIR__ . '/../lib/mysqli.php';

$link = dbConnect();

$sqls = [
  <<<EOT
DROP TABLE IF EXISTS forum;
EOT,

  <<<EOT
CREATE TABLE forum (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  text VARCHAR(100) NOT NULL,
  timestamp DATETIME NOT NULL DEFAULT NOW()
) DEFAULT CHARACTER SET=utf8mb4;
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
