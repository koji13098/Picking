# ピッキングアプリ
https://thawing-wave-36712.herokuapp.com/


## 概要
職場で使われていたツールを再現しました。一部の機能はオリジナルです。


## 機能一覧

* #### [ピッキング](https://thawing-wave-36712.herokuapp.com/readList.php)
  送り状番号を入力してピッキングリストを取得し、表示されたロケーションに行き、品番のQRコードを読み取ってピッキングしていく機能。

* #### [検品DBチェックなし](https://thawing-wave-36712.herokuapp.com/awase.html)
  品番が一致しているかどうかを確認する機能。

* #### [時間計算表](https://thawing-wave-36712.herokuapp.com/timeCalculator.html)
  各作業の時間の合計を計算する機能。オリジナルで作りました。

* #### [意見・要望](https://thawing-wave-36712.herokuapp.com/forum.php)
  掲示板。オリジナルで作りました。


## 使用技術
* Docker 20.10.17
* Docker Compose 2.7.0
* PHP 8.1
* Apache 2.4 (Debian)
* MySQL 8.0
* Heroku
* Composer
* [PHP dotenv](https://github.com/vlucas/phpdotenv)
* [jsQR](https://github.com/cozmo/jsQR)


## 使用した技術の選定理由

プログラミングの学習で使っていたため。


## 開発の経緯

職場で使わているツールをいじってみたかったが、開発環境を用意することができなかったので、自前の環境でツールを再現して自分で改造しようと思った。

[時間計算表](#時間計算表)は、自分と職場の人が、各作業時間とその合計時間の計算を面倒と感じていたから作りました。

[意見・要望](#意見・要望)は、何かバグや他に欲しい機能があったときに報告しやすくするため。
