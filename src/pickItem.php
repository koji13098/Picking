<?php

session_start();

$pickingLists = $_SESSION['pickingLists'];
sort($pickingLists);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['item_number'] === $pickingLists[(int)$_POST['pickNum']]['item_number']) {
        $pickNum = (int)$_POST['pickNum'];
        echo '<script>alert("読込No:' . $pickingLists[$pickNum]['readNum'] . '\n' . $pickingLists[$pickNum]['item_number'] . '\n数量: ' . $pickingLists[$pickNum]['amount'] . '");</script>';
        $pickNum++;
    } else {
        $pickNum = (int)$_POST['pickNum'];
        echo '<script>alert("品番違い\n' . $_POST['item_number'] . '");</script>';
    }
} else {
    $pickNum = (int)$_GET['pickNum'];
}
if ($pickNum >= count($pickingLists)) {
    header("Location: pickingEnd.php");
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>バラピッキング</title>
</head>

<body>
    <script src="lib/popup.js"></script>
    <h1>バラピッキング</h1>
    <h2>品番読取</h2>
    <p><?php echo $pickNum + 1; ?>/<?php echo count($pickingLists); ?>件</p>
    <p>読込NO:<?php echo $pickingLists[$pickNum]['readNum']; ?></p>
    <div>
        <p>送り状:</p>
        <p><?php echo $pickingLists[$pickNum]['invoiceNum']; ?></p>
    </div>
    <div>
        <p>ロケ:</p>
        <p><?php echo $pickingLists[$pickNum]['location']; ?></p>
        <p>数量:<?php echo $pickingLists[$pickNum]['amount']; ?></p>
    </div>
    <div>
        <p>品番:</p>
        <p><?php echo $pickingLists[$pickNum]['item_number']; ?></p>
    </div>
    <form action="pickItem.php" method="post">
        <div>
            <input type="hidden" name="pickNum" value="<?php echo $pickNum; ?>">
            <input type="text" name="item_number">
            <input type="submit" value="読込">
        </div>
    </form>
    <footer>
        <form action="index.php" method="get" onsubmit="return popupConfirm('ピッキング処理を取り消し、読み込んだ送り状番号をすべて破棄します。よろしいでしょうか？');">
            <input type="submit" value="戻る">
        </form>
        <form action="pickItem.php" method="get" onsubmit="return popupConfirm('スキップしてもよろしいでしょうか？');">
            <input type="hidden" name="pickNum" value="<?php echo $pickNum + 1; ?>">
            <input type="submit" value="スキップ">
        </form>
    </footer>
</body>

</html>
<?php
