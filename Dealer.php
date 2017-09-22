<?php
  require_once(__dir__."/CardSet.php");
  require_once(__dir__."/Player.php");

  Class Dealer extends Player {

    private $cardset;

    /**
     * Dealer は新しいカードセットを作成。
     *
     * @param $name dealer の名前
     */
    public function __construct($name) {
      parent::__construct($name);
      $this->createNewCardSet();
    }

    /**
     * 新しいカードセットを生成
     */
    public function createNewCardSet() {
      $cardset = Cardset::make(false);
      $cardset = Cardset::shuffle($cardset);

      $this->cardset = $cardset;
    }

    /**
     * Dealer は Player にカードを１枚配る。
     *
     * @param $player カードの配り先
     * @return 配れるカードがある。-> true / ない -> false
     */
    public function deal(Player $player) {

      if (count($this->cardset) == 0) {
        return false;
      }

      $card = $this->cardset[0];
      $player->hit($card);

      //
      unset($this->cardset[0]);
      $this->cardset = array_values($this->cardset);
      return true;
    }

    /**
     * Dealer との勝敗判定 (数字は判定順序)
     * 1. player が 22 以上 : dealer の勝ち
     * 2. dealer が 22 以上 : dealer の負け
     * 3. 点数の高いほうが勝ち
     *
     * @param $player $dealer と勝敗判定を行う player
     * @return 正数 : dealer の勝ち, 0 : draw, 負数 : dealer の負け
     */
    public function judge(Player $player) {
      if ($player->isBurst) return 1;
      elseif ($this->isBurst) return -1;
      else {
        $ds = $this->getScore();
        $ps = $player->getScore();
        return ($ds - $ps);
      }
    }

    public function toMaskedString() {
      $format = "%s's score ** (%s **)";
      return sprintf($format, $this->name, $this->getCardIndexOf(0));
    }
  }
  /**
   * Copyright 2017 fukumame
   */
