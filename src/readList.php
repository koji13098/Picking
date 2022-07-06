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
                    $item_number = trim(substr($data['item_number'], 0, 13)) . substr($data['item_number'], -7, 3);
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
    <link rel="stylesheet" href="stylesheets\readList.css">

    <title>バラピッキング</title>
</head>

<body>
    <header>バラピッキング</header>
    <h2 class="title">送り状番号読取</h2>
    <div class="body">
        <form class="readlist" action="readList.php" method="post">
            <label for="invoiceNum">送り状バーコードを読んでください</label>
            <input class="input" type="text" name="invoiceNum" id="invoiceNum">
            <input type="submit" value="読込">
            <p>枚数：<?php echo count($_SESSION['invoiceNumbers']); ?></p>
        </form>
    </div>
    <footer>
        <form action="index.php" method="get" onsubmit="<?php echo (count($_SESSION['invoiceNumbers']) > 0) ? "return popupConfirm('戻りますか？')" : "" ?>">
            <input type="submit" value="戻る">
        </form>
        <form action="<?php echo (count($_SESSION['invoiceNumbers']) === 0) ? "readList.php" : "pickItem.php"; ?>" method="get" onsubmit="<?php echo (count($_SESSION['invoiceNumbers']) === 0) ? "return alert('送り状が読み込まれていません')" : "" ?>">
            <input type="hidden" name="pickNum" value="0">
            <input type="submit" value="ピッキング">
        </form>
    </footer>
    <script src="lib/popup.js"></script>
</body>

</html>
