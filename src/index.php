<?php
session_cache_limiter('private');
session_cache_expire(30);
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./stylesheets/style.css">
    <title>検品システム</title>
</head>

<body>
    <header>検品システム v0.1</header>
    <ol>
        <li>
            <a href="readList.php">ピッキング</a>
        </li>
        <li>
            <a href="awase.html">検品DBチェックなし</a>
        </li>
    </ol>
</body>

</html>
