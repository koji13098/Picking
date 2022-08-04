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
    <link rel="stylesheet" href="stylesheets\readList.css">

    <title>バラピッキング</title>
</head>

<body>
    <header>バラピッキング</header>
    <h2 class="title">品番読取</h2>
    <div class="main">
        <p class="pick-num"><?php echo $pickNum + 1; ?>/&nbsp;<?php echo count($pickingLists); ?>&nbsp;件</p>
        <p>読込No:<span class="value"><?php echo $pickingLists[$pickNum]['readNum']; ?></span></p>
        <div>
            <p>送り状:<br>
                <span class="value"><?php echo $pickingLists[$pickNum]['invoiceNum']; ?></span>
            </p>
        </div>
        <div class="location-amount">
            <div class="location">ロケ:<br>
                <span class="value"><?php echo $pickingLists[$pickNum]['location']; ?></span>
            </div>
            <div class="amount">数量:<br>
                <span class="value">&nbsp;<?php echo $pickingLists[$pickNum]['amount']; ?></span>
            </div>
        </div>
        <div>
            <p>品番:<br>
                <span class="value"><?php echo $pickingLists[$pickNum]['item_number']; ?></span>
            </p>
        </div>
        <form action="pickItem.php" method="post">
            <div>
                <input type="hidden" name="pickNum" value="<?php echo $pickNum; ?>">
                <input class="input" type="text" name="item_number">
                <input type="submit" value="読込">
            </div>
        </form>
    </div>
    <footer>
        <form action="index.php" method="get" onsubmit="return popupConfirm('ピッキング処理を取り消し、読み込んだ送り状番号をすべて破棄します。よろしいでしょうか？');">
            <input type="submit" value="戻る">
        </form>
        <form action="pickItem.php" method="get" onsubmit="return popupConfirm('スキップしてもよろしいでしょうか？');">
            <input type="hidden" name="pickNum" value="<?php echo $pickNum + 1; ?>">
            <input type="submit" value="スキップ">
        </form>
    </footer>
    <script src="lib/popup.js"></script>
</body>

</html>
<?php
