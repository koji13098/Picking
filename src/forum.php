<?php

require_once __DIR__ . '/lib/mysqli.php';

function escape($str): string
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function getMessages($link): array
{
  $messages = [];
  $sql = 'SELECT id, text, timestamp FROM forum';
  $result = mysqli_query($link, $sql);
  if (!$result) {
    error_log("Error: " . mysqli_error($link));
    return ['投稿一覧を取得できませんでした'];
  }
  while ($message = mysqli_fetch_assoc($result)) {
    $messages[] = $message;
  }
  return $messages;
}

session_start();

$text = (string)filter_input(INPUT_POST, 'text');
$token = (string)filter_input(INPUT_POST, 'token');

$link = dbConnect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $text && sha1(session_id() === $token)) {
  $sql = 'INSERT INTO forum (text) VALUES ("' . $text . '")';

  if (!($result = mysqli_query($link, $sql))) {
    error_log("Error: " . mysqli_error($link));
  }

  session_regenerate_id(true);
  header("Location:forum.php");
}

$messages = array_reverse(getMessages($link));

mysqli_close($link);

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
    <?php if (empty($messages)) : ?>
      <p>投稿はまだありません</p>
    <?php else : ?>
      <ul>
        <?php foreach ($messages as $message) : ?>
          <li>
            <div class="forum-header">
              <?= escape(($message['id'] - 4) / 10) ?>.&nbsp;<?= escape($message['timestamp']) ?>
            </div>
            <div class="forum-text">
              <?= escape($message['text']) ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
  <footer>
    <button class="button" id="js-quit"><a href="./index.php">戻る</a></button>
  </footer>
