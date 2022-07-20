<?php

require_once __DIR__ . "/lib/mysqli.php";

session_start();

function getPickList($link, string $invoiceNum): mysqli_result
{
    $sql = <<<EOT
        SELECT
        l.location,
        o.item_number,
        o.amount
        FROM
        orders as o
            INNER JOIN locations as l
            ON o.item_number = l.item_number
        WHERE
        invoice = "{$invoiceNum}"
        ;
    EOT;
    $pickList = mysqli_query($link, $sql);
    if (!$pickList) {
        echo "<script>alert('データを取得できませんでした');</script>";
        echo 'Error: ' . mysqli_error($link);
        exit();
    }

    return $pickList;
}

$link = dbConnect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($invoiceNum = trim($_POST['invoiceNum'])) {
        if (!in_array($invoiceNum, $_SESSION['invoiceNumbers'], true)) {
            $result = getPickList($link, $invoiceNum);
            if ($result->num_rows > 0) {
                $_SESSION['invoiceNumbers'][] = $invoiceNum;
                while ($data = mysqli_fetch_assoc($result)) {
                    $item_number = trim($data['item_number']);
                    $_SESSION['pickingLists'][] = [
                        'location' => $data['location'],
                        'readNum' => count($_SESSION['invoiceNumbers']),
                        'invoiceNum' => $invoiceNum,
                        'item_number' => $item_number,
                        'amount' => $data['amount'],
                    ];
                }
            } else {
                echo "<script>alert('出荷指示未登録');</script>";
            }
            mysqli_free_result($result);
        } else {
            echo "<script>alert('読込済');</script>";
        }
    } else {
        echo "<script>alert('送り状が読み込まれていません');</script>";
    }
} else {
    $_SESSION['invoiceNumbers'] = [];
    $_SESSION['pickingLists'] = [];
}
mysqli_close($link);

?>

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
    <div class="title">送り状番号読取</div>
    <div class="main">
        <form class="read-list-form" action="readList.php" method="post">
            <label for="invoiceNum">送り状バーコードを読んでください</label>
            <input class="input" type="text" name="invoiceNum" id="invoiceNum">
            <button type="submit">読込</button>
            <p>枚数：<?php echo count($_SESSION['invoiceNumbers']); ?></p>
        </form>
    </div>
    <footer>
        <form action="index.php" method="get" onsubmit="<?php echo (count($_SESSION['invoiceNumbers']) > 0) ? "return popupConfirm('読み込んだ送り状番号をすべて破棄します。よろしいでしょうか？')" : "" ?>">
            <button type="submit">戻る</button>
        </form>
        <form action="<?php echo (count($_SESSION['invoiceNumbers']) === 0) ? "readList.php" : "pickItems.php"; ?>" method="get" onsubmit="<?php echo (count($_SESSION['invoiceNumbers']) === 0) ? "return alert('送り状が読み込まれていません')" : "" ?>">
            <input type="hidden" name="pickNum" value="0">
            <button type="submit">ピッキング</button>
        </form>
    </footer>
    <script src="lib/popup.js"></script>
</body>

</html>
