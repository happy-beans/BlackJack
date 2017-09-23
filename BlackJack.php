<?php

  require_once(__dir__."/Dealer.php");
  require_once(__dir__."/Player.php");
  require_once(__dir__."/Strategy.php");
  /** - - - - - - - - - - - - - - - - - - - - - - - - - - - -
   *  BlackJack CUI用コントローラ
   *  開発・実行環境：macOS 10.12.6 / php7.2.0(beta3)
   *  - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
  $ctrl = new Controller();
  $ctrl->run();

  Class Controller {

    private $dealer;
    private $players;

    const WINS = "%s wins.";
    const LOSES = "%s loses.";
    const BURSTS = "%s bursts.";
    const HITS = "%s hits.";
    const DRAW = "draw.";
    const HIT_OR_STAND = "hit or stand？(h/s) > ";
    const START = "start";
    const END = "end";

    /**
     * 1. dealer の生成
     * 2. player の生成
     * ディーラーにカードを配る
     */
    public function __construct() {
      $this->dealer = new Dealer("dealer");
      $this->dealer->createNewCardSet();

      $this->players = [];
      array_push($this->players, $this->makeUser("player1"));

      $this->dealer->deal($this->dealer);
      $this->dealer->deal($this->dealer);
    }

    /**
     * ユーザーを作成してカードを配る
     * @param $username 作成するユーザーの名前
     */
    private function makeUser($username) {
      $p = new Player($username);
      $this->dealer->deal($p);
      $this->dealer->deal($p);
      return $p;
    }

    /**
     * ゲームの進行
     * ・画面のクリア
     * ・player のターン
     * ・dealer のターン
     * ・勝敗判定
     */
    public function run() {
      system("clear");
      $this->showMsg(self::START);

      print($this->getWhiteSpace(2).$this->dealer->toMaskedString().PHP_EOL);
      $this->runUser();
      $this->runDealer();

      foreach($this->players as $player) {
        $ret = $this->dealer->judge($player);
        if ($ret > 0) {
          print($this->getWhiteSpace(2).$this->getMessage($player, self::LOSES).PHP_EOL);
        }
        elseif ($ret < 0) {
          print($this->getWhiteSpace(2).$this->getMessage($player, self::WINS).PHP_EOL);
        }
        else {
          print($this->getWhiteSpace(2).self::DRAW.PHP_EOL);
        }
      }
      $this->showMsg(self::END);
    }

    private function showMsg($msg) {
      print (PHP_EOL);
      print ("/** ----------------------- * ".PHP_EOL);
      print (sprintf(" *   Black Jack game %s.", $msg).PHP_EOL);
      print (" *  ----------------------- */".PHP_EOL);
      print (PHP_EOL);
    }

    /**
     * player の点数を表示して次をめくるかどうかを入力してもらう。
     * 点数が21を超えたら次のカードはめくれない。
     */
    private function runUser() {
      // user
      foreach ($this->players as $player) {
        while (true) {
          print($this->getWhiteSpace(2).$player->toString().PHP_EOL);

          while (true) {
            print($this->getWhiteSpace(4).self::HIT_OR_STAND);
            $ans = trim(fgets(STDIN));

            // 'h(it)'
            // if ($ans == "h") {
            if (preg_match("/^[hH]$/", $ans)) {
              $this->dealer->deal($player);
              print(PHP_EOL);
              print($this->getWhiteSpace(2).$player->toString().PHP_EOL);
              if ($player->isBurst()) {
                print($this->getWhiteSpace(4).$this->getMessage($player, self::BURSTS).PHP_EOL);
                break 2;
              }
            }

            // 's(tand)'
            elseif (preg_match("/^[sS]$/", $ans)) {
              print(PHP_EOL);
              break 2;
            }
          }
        }
      }
    }

    private function runDealer() {

      print($this->getWhiteSpace(2).$this->dealer->toString().PHP_EOL);
      while(true) {
        if (Strategy::hasNext($this->dealer, 1)) {
          print($this->getWhiteSpace(4).$this->getMessage($this->dealer, self::HITS).PHP_EOL);
          $this->dealer->deal($this->dealer);
          print(PHP_EOL);
          print($this->getWhiteSpace(2).$this->dealer->toString().PHP_EOL);
          if ($this->dealer->isBurst()) {
            print($this->getWhiteSpace(4).$this->getMessage($this->dealer, self::BURSTS).PHP_EOL);
            break;
          }
        }
        else {
          break;
        }
      }
    }

    private function getmessage($player, $msg) {
      return sprintf($msg, $player->getName());
    }

    private static function getWhiteSpace($size) {
      return str_pad("", $size, " ");
    }
  }
  /**
   * Copyright 2017 happy-beans / fukumame
   */
