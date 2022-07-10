<?php

session_start();

$pickingLists = $_SESSION['pickingLists'];
sort($pickingLists);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_number = trim(substr($_POST['item_number'], 0, 13)) . substr($_POST['item_number'], 14, 3);
    if ($item_number === $pickingLists[(int)$_POST['pickNum']]['item_number']) {
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
    <div class="main" id="js-pickingList">
        <p class="pick-num" id="js-pick-num"><?php echo $pickNum + 1; ?>/&nbsp;<?php echo count($pickingLists); ?>&nbsp;件</p>
        <p>読込No:<span class="value"><?php echo $pickingLists[$pickNum]['readNum']; ?></span></p>
        <div id="js-invoice-num">
            <p>送り状:<br>
                <span class="value"><?php echo $pickingLists[$pickNum]['invoiceNum']; ?></span>
            </p>
        </div>
        <div class="location-amount" id="js-location">
            <div class="location">ロケ:<br>
                <span class="value"><?php echo $pickingLists[$pickNum]['location']; ?></span>
            </div>
            <div class="amount" id="js-amount">数量:<br>
                <span class="value">&nbsp;<?php echo $pickingLists[$pickNum]['amount']; ?></span>
            </div>
        </div>
        <div id="js-item-number">
            <p>品番:<br>
                <span class="value"><?php echo $pickingLists[$pickNum]['item_number']; ?></span>
            </p>
        </div>
        <form name="form" action="pickItems.php" method="post">
            <div>
                <input type="hidden" name="pickNum" value="<?php echo $pickNum; ?>">
                <input id="js-input" class="input" type="text" name="item_number">
                <input id="js-submit" type="submit" value="読込">
            </div>
        </form>
    </div>

    <video class="video" id="js-video" width="640" height="480" autoplay playsinline></video>
    <canvas id="js-canvas" width="640" height="480" style="display: none;"></canvas>

    <footer>
        <form action="index.php" method="get" onsubmit="return popupConfirm('ピッキング処理を取り消し、読み込んだ送り状番号をすべて破棄します。よろしいでしょうか？');">
            <input type="submit" value="戻る">
        </form>
        <form action="pickItems.php" method="get" onsubmit="return popupConfirm('スキップしてもよろしいでしょうか？');">
            <input type="hidden" name="pickNum" value="<?php echo $pickNum + 1; ?>">
            <input type="submit" value="スキップ">
        </form>
    </footer>

    <script src="./lib/popup.js"></script>
    <script src="./lib/jsQR.js"></script>
    <script src="./lib/pickItems.js"></script>
</body>

</html>
<?php
