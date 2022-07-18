<?php

session_start();

$pickingLists = $_SESSION['pickingLists'];
sort($pickingLists);

$pickingLists_json = json_encode($pickingLists);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $item_number = trim(substr($_POST['item_number'], 0, 13)) . substr($_POST['item_number'], 13, 3);
//     if ($item_number === $pickingLists[(int)$_POST['pickNum']]['item_number']) {
//         $pickNum = (int)$_POST['pickNum'];
//         echo '<script>alert("読込No:' . $pickingLists[$pickNum]['readNum'] . '\n' . $pickingLists[$pickNum]['item_number'] . '\n数量: ' . $pickingLists[$pickNum]['amount'] . '");</script>';
//         $pickNum++;
//     } else {
//         $pickNum = (int)$_POST['pickNum'];
//         echo '<script>alert("品番違い\n' . $_POST['item_number'] . '");</script>';
//     }
// } else {
//     $pickNum = (int)$_GET['pickNum'];
// }
// if ($pickNum >= count($pickingLists)) {
//     header("Location: pickingEnd.php");
// }

?>

<script>
    let pickingLists = JSON.parse('<?php echo $pickingLists_json; ?>');
    console.log(pickingLists);
</script>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylesheets\style.css">

    <title>バラピッキング</title>
</head>

<body>
    <header>バラピッキング</header>
    <h2 class="title">品番読取</h2>
    <div class="main" id="js-pickingList">
        <div class="pick-num pickNum" id="js-pickNum"></div>
        <div>読込No:<span class="value readNum" id="js-readNum"></span></div>
        <div>送り状:<br>
            <span class="value invoiceNum" id="js-invoiceNum"></span>
        </div>
        <div class="location-amount">
            <div class="location">ロケ:<br>
                <span class="value location" id="js-location"></span>
            </div>
            <div class="amount">数量:<br>
                <span class="value amount" id="js-amount"></span>
            </div>
        </div>
        <div>品番:<br>
            <div class="item_number value">
                <span class="item_number1" id="js-itemNumber1"></span>
                <span class="item_number2" id="js-itemNumber2"></span>
            </div>
        </div>
        <form name="form" action="pickItems.php" method="post">
            <div>
                <input id="js-input" class="input" type="text" name="item_number">
                <input id="js-submit" type="submit" value="読込">
            </div>
        </form>
    </div>

    <footer>
        <button id="js-quit">戻る</button>
        <button id="js-skip">スキップ</button>
    </footer>

    <video class="video" id="js-video" width="376" height="667" autoplay playsinline></video>
    <canvas id="js-canvas" width="376" height="667" style="display: none;"></canvas>

    <div class="complete">照合ＯＫ</div>

    <div class="popup popup-correct" id="js-popup-correct">
        <div class="popup-content">
            <div>読込No:<span class="readNum"></span></div>
            <div>
                <span class="item_number1"></span>
                <span class="item_number2"></span>
            </div>
            <div>数量:<span class="value amount"></span>
            </div>
            <button class="button" id="js-popup-correct-close">OK</button>
        </div>
    </div>

    <div class="incorrect">照合エラー</div>

    <div class="popup popup-incorrect" id="js-popup-incorrect">
        <div class="popup-content">
            <div>品番違い<br>
                <div>
                    <span class="read_item_number"></span>
                </div>
            </div>
            <button class="button" id="js-popup-incorrect-close">確認</button>
        </div>
    </div>

    <script src="./lib/popup.js"></script>
    <script src="./lib/jsQR.js"></script>
    <script src="./lib/pickItems.js"></script>
</body>

</html>
