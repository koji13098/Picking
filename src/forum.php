<?php

date_default_timezone_set('Asia/Tokyo');

function escape($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

session_start();

$text = (string)filter_input(INPUT_POST, 'text');
$token = (string)filter_input(INPUT_POST, 'token');

$file = fopen('./forum.csv', 'a+b');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $text && sha1(session_id() === $token)) {
  header("Location:forum.php");
  flock($file, LOCK_EX);
  fputcsv($file, [date('Y/m/d/H:i:s'), $text]);
  rewind($file);
  session_regenerate_id(true);
}

$rows = [];
flock($file, LOCK_SH);
while ($row = fgetcsv($file)) {
  $rows[] = $row;
}
$rowsReversed = array_reverse($rows);
flock($file, LOCK_UN);
fclose($file);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="stylesheets\style.css">

  <title>意見・要望</title>
</head>

<body>
  <header>意見・要望</header>
  <div class="new-forum">
    <div class="title">新規投稿</div>
    <p>※個人を特定できるようなことを書かないようにお願いします。</p>
    <form action="#" method="post" onsubmit="return confirm('送信しますか？')">
      <textarea name="text" cols="40" rows="5" wrap="hard"></textarea>
      <input type="submit" value="送信">
      <input type="hidden" name="token">
    </form>
  </div>
  <div class="forum-list">
    <div class="title">投稿一覧</div>
    <?php if (empty($rowsReversed)) : ?>
      <p>投稿はまだありません</p>
    <?php else : ?>
      <ul>
        <?php foreach ($rowsReversed as $row) : ?>
          <li>
            <div class="forum-text">
              <?= escape($row[1]) ?>
            </div>
            <div class="forum-date">
              <?= escape($row[0]) ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
  <footer>
    <button class="button" id="js-quit"><a href="./index.php">戻る</a></button>
  </footer>
