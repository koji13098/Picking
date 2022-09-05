# ピッキングアプリ
https://thawing-wave-36712.herokuapp.com/


## 概要
職場で使われていたツールを再現しました。一部の機能はオリジナルです。


## 機能一覧

* #### [ピッキング](https://thawing-wave-36712.herokuapp.com/readList.php)
  送り状番号を入力してピッキングリストを取得し、表示されたロケーションに行き、品番のQRコードを読み取ってピッキングしていく機能。  
  
  ![picking](https://user-images.githubusercontent.com/102679099/188513861-9e6995f0-76d2-4133-ac89-f21a989730f3.gif)

* #### [検品DBチェックなし](https://thawing-wave-36712.herokuapp.com/awase.html)
  品番が一致しているかどうかを確認する機能。  
  
  正しい時  
  
  ![awase-correct](https://user-images.githubusercontent.com/102679099/188514680-2ccc7c21-9756-4205-8e67-b3f263ad6da5.gif)  
  
  違う時  
  
  ![awase-incorrect](https://user-images.githubusercontent.com/102679099/188514736-536416c0-a6bd-4de8-81f9-bb39345f7f9b.gif)

* #### [時間計算表](https://thawing-wave-36712.herokuapp.com/timeCalculator.html)
  各作業の時間の合計を計算する機能。オリジナルで作りました。  
  
  ![time-calcurator](https://user-images.githubusercontent.com/102679099/188514476-ca80f340-04de-4a6c-ab10-39c2fc7bac7a.png)

* #### [意見・要望](https://thawing-wave-36712.herokuapp.com/forum.php)
  掲示板。オリジナルで作りました。  
  
  ![forum](https://user-images.githubusercontent.com/102679099/188514523-a117be5f-028b-4cab-a9c9-37a2eb92ff66.png)


### 品番一覧

K34BNZ-JAN300  
![K34BNZ-JAN3000001](https://user-images.githubusercontent.com/102679099/188515015-8c909dc9-e8f7-4529-b796-ad837886e7f3.png)

KF100N2SS-JAN000  
![KF100N2SS-JAN0000001](https://user-images.githubusercontent.com/102679099/188515024-8a86719d-f6cb-42fa-897f-140e899f78e6.png)

ZK10-JAN800  
![ZK10-JAN8000001](https://user-images.githubusercontent.com/102679099/188515029-2ffdab67-1f05-4b9e-9e46-0585d3ccd277.png)


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

プログラミングの学習で使っていたためです。  


## 開発の経緯

職場で使われているツールが使いにくいと感じていて、自分で改善してみたかったのですが、開発環境を用意することができなかったので、自前の環境でツールを再現して改造しようと思ったからです。

[時間計算表](#時間計算表)は、自分と職場の人が、各作業時間とその合計時間の計算を面倒と感じていたから作りました。

[意見・要望](#意見・要望)は、何かバグや他に欲しい機能があったときに報告しやすくするために作ろうと思いました。

## 反省点

１か月という期間しかなかったので、当初の目的の改善という部分ができず、再現だけで終わってしまったことです。  
これは開発の見積もりが甘かったことと、単に自分の開発経験がなかったことが原因でした。  
対策としては、開発の経験を積んでいくことが良いのかと思います。  

もう一つは、見た目の部分（HTML, CSS）をもっと良くしたかったことです。  
これは単に経験不足が原因でした。  
対策としては、ウェブサイトをコピーするなどの実践経験を積んだり、フレームワークを使用したりすることが良いかと思います。  
