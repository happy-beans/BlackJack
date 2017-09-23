<?php
/**
 * Card.php
 * Copyright 2017 happy-beans / fukumame
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */
  require_once(__dir__."/Suit.php");

  Class Card {

    private $suit;
    private $number;

    public function __construct($suit, $number) {
      // number の妥当性
      if (!self::isValidNumber($number) || !self::isValidSuit($suit)) {
        throw new InvalidArgumentException("InvalidArgumentException : suit = ".$suit.", number = ".$number);
      }

      $this->suit = $suit;
      $this->number = $number;
    }

    /**
     * トランプの数字として妥当かどうかを判定。
     *
     * @param $numer トランプの数字候補
     * @return true : 1から13までのint型正数, false : float型の正数、負数、ゼロ
     */
    private static function isValidNumber($number) {
      if (!is_int($number)) return false;
      elseif ($number < 1) return false;
      elseif ($number > 13) return false;
      else return true;
    }

    /**
     * トランプのSuitとして妥当かどうかを判定。
     *
     * @param $suit トランプの suit 候補
     * @return true : Suit::SUITS に定義されている、false : 定義されていない。
     */
    private static function isValidSuit($suit) {
      foreach (Suit::SUITS as $s) {
        if ($suit == $s) return true;
      }
      return false;
    }

    public function getSuit() {
      return $this->suit;
    }

    public function getNumber() {
      return $this->number;
    }

    public function toString() {
      return $this->toShortString();
    }

    public function toShortString() {
      $a = [
        "1" => "A",
        "2" => "2",
        "3" => "3",
        "4" => "4",
        "5" => "5",
        "6" => "6",
        "7" => "7",
        "8" => "8",
        "9" => "9",
        "10" => "10",
        "11" => "J",
        "12" => "Q",
        "13" => "K"
      ];
      return substr($this->suit, 0, 1).$a[$this->number];
    }
  }
