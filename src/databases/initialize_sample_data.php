<?php

require_once __DIR__ . '/../lib/mysqli.php';

$link = dbConnect();

$sqls = [

  "DROP TABLE IF EXISTS locations;",

  <<<EOT
CREATE TABLE locations (
  item_number VARCHAR(20) NOT NULL PRIMARY KEY,
  location VARCHAR(7) NOT NULL
);
EOT,

  "DROP TABLE IF EXISTS orders;",

  <<<EOT
CREATE TABLE orders (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  invoice VARCHAR(20) NOT NULL,
  item_number VARCHAR(20) NOT NULL,
  amount INTEGER NOT NULL
);
EOT,

  <<<EOT
INSERT INTO locations (
  item_number,
  location
) VALUES (
  "KF100N2SS-JAN0000001",
  "B151211"
);
EOT,

  <<<EOT
INSERT INTO locations (
  item_number,
  location
) VALUES (
  "ZK10-JAN     8000001",
  "B151512"
);
EOT,

  <<<EOT
INSERT INTO locations (
  item_number,
  location
) VALUES (
  "K34BNZ-JAN   3000001",
  "B148242"
);
EOT,

  <<<EOT
INSERT INTO orders (
  invoice,
  item_number,
  amount
) VALUES (
  "123456789",
  "ZK10-JAN     8000001",
  2
);
EOT,

  <<<EOT
INSERT INTO orders (
  invoice,
  item_number,
  amount
) VALUES (
  "987654321",
  "K34BNZ-JAN   3000001",
  5
);
EOT,

  <<<EOT
INSERT INTO orders (
  invoice,
  item_number,
  amount
) VALUES (
  "123456789",
  "KF100N2SS-JAN0000001",
  1
);
EOT,

];

foreach ($sqls as $sql) {
  $result = mysqli_query($link, $sql);

  if ($result) {
    echo 'Added data' . PHP_EOL;
  } else {
    echo mysqli_error($link);
  }
}

mysqli_close($link);
