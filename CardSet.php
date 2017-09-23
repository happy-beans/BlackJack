<?php
/**
 * CardSet.php
 * Copyright 2017 happy-beans / fukumame
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */
  require_once(__dir__."/Card.php");
  require_once(__dir__."/Suit.php");

  Class CardSet {

    /**
     * cardsetを作成
     *
     * TODO @param useJoker true / false
     * @return cardset
     */
    public static function make($useJoker) {

      $cardset = null;
      foreach (Suit::SUITS as $suit) {
        for ($num = 1; $num <= 13; $num++) {
          $c = new Card($suit, $num);
          if ($cardset == null) {
            $cardset = array($c);
          }
          else {
            array_push($cardset, $c);
          }
        }
      }

      /*
      if ($useJoker) {
        $c = new Card("JOKER", 0);
        array_push($cardset, $c);
      }
      */

      return $cardset;
    }

    /**
     * cardsetをシャッフル
     *
     * @param $cardset 配列
     * @return $cardset シャッフルした配列
     */
    public static function shuffle($cardset) {

      $count = rand(1, 10);
      for ($i = 0; $i < $count; $i++) {
        shuffle($cardset);
      }
      return $cardset;
    }
  }
