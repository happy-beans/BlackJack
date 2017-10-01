## BlackJack
#### 0. ライセンス
 * Copyright 2017 happy-beans / fukumame
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php

#### 1. 開発環境
  - macOS 10.12.6
  - php7.2.0(beta3)

#### 2. 起動
  $ php BlackJack.php

#### 3. ルール
  1. ゲームを起動すると、Player と Dealer にカードが２枚ずつ配られる。
  2. Dealer に配られた１枚めのカードと手札を見て、もう一枚もらう(hit)かもらわない(stand) かどうかを画面に従って入力。
  3. 点数については以下の通り。
    - 1 : 1 or 11 (ただし選択不可。11で加算して21を超えない場合は11, 超える場合は1となる。)
    - 2 - 10 : 表示の数字通り
    - 11(J), 12(Q), 13(K) : すべて10
  4. Player の点数が 21 より大きくなったらその時点で Player の負け。
  5. Player が stand すると、Dealer がカードをめくる。
  6. Dealer が 21 を超えるとその場で Dealer の負けとなるが、Dealer が 21 以下の場合は Player と勝負。
    - Player の点数 > Dealer の点数 : Player の勝ち
    - Player の点数 < Dealer の点数 : Player の負け
    - Player の点数 = Dealer の点数 : ドローゲーム
  7. ゲームが１回終了するとアプリは終了する。対戦結果は保持されない。

#### 4. Class
| ファイル名 | Class | 説明 |
|:------|:----|:----|
| BlackJack.php | Controller | CUI 上でのゲーム進行管理 |
| Card.php | Card | トランプカードの１枚 |
| CardSet.php | CardSet | トランプ一式（jokerを含まない52枚) |
| Dealer.php | Dealer | CardSetを保持して、Player にカードを配る。Dealer自身もPlayerを継承していて、Playerの対戦相手となる |
| Player.php | Player | ゲームを行うPlayer |
| Strategy.php | Strategy | Dealer がカードをめくるかどうかを判断 |
| Suit.php | Suit | トランプのSuitを定義 |

#### 5. history
  - 2017.09.20 初版作成

#### 6. ひとこと
  - php コーディングによるサンプルソース。
  - 当該ソースはここのurl[https://github.com/happy-beans/BlackJack]にしか掲載していません。
