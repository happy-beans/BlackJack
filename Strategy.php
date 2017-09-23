<?php
  require_once(__dir__."/Player.php");

  Class Strategy {

    /**
     * 手札の状況から次をめくるかどうかを判定。
     *
     * @param $player 対象player
     * @param $level めくるかどうかの判定ルール
     * @return true : 次のカードをめくる。 false : 次のカードをめくらない。
     */
    public static function hasNext(Player $player, int $level) {

      if ($player->isBurst()) return false;

      $ret = false;
      switch($level) {
        case 1:
          $ret = self::level1($player);
        default:
          break;
      }

      return $ret;
    }

    /**
     *
     *
     */
    private static function level1(Player $player) {
      return ($player->getScore() <= 16) ? true : false;
    }
  }
  /**
   * Copyright 2017 happy-beans / fukumame
   */
