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
    <title>一覧</title>
</head>

<body>
    <a href="readList.php">ピッキング</a>
</body>

</html>
