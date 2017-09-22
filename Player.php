<?php
  require_once(__dir__."/Card.php");

  Class Player {

    protected $name;
    private $score;
    private $deck;
    protected $isBurst;

    public function __construct($name) {
      $this->name = $name;
      $this->score = 0;
      $this->deck = [];
      $this->isBurst = false;
    }

    /**
     * カードを引く
     *
     * @param $card
     */
     public function hit(Card $card) {
       array_push($this->deck, $card);
       $this->score = $this->calc();
       $this->isBurst = ($this->score > 21) ? true : false;
     }

     /**
      * 点数計算
      *
      * @return Player の現在の点数
      */
     private function calc() {

       $hasAce = false;
       $this->score = 0;
       foreach ($this->deck as $card) {
         $score = $card->getNumber();
         $suit = $card->getSuit();
         // print($suit." : ".$score.PHP_EOL);

         if ($score == 1) $hasAce = true;
         $this->score += (($score > 10) ? 10 : $score);
       }

       // Ace を引いたとき、点数合計が 11点以下なら Ace = 11 としてカウント。
       if (($this->score <= 11) && ($hasAce)) $this->score += 10;

       return $this->score;
     }

     public function toString() {
       $format = "%s's score %d (%s)";
       $ret = "";
       foreach ($this->deck as $card) {
         if ($ret == "") {
           $ret = $card->toShortString();
         }
         else {
           $ret = $ret.", ".$card->toShortString();
         }
       }
       return sprintf($format, $this->name, $this->calc(), $ret);
     }

     public function getName() {
       return $this->name;
     }

     public function getScore() {
       return $this->score;
     }

     public function getDeck() {
       return $this->deck;
     }

     public function isBurst() {
       return $this->isBurst;
     }

     public function getCardIndexOf($index) {
       return $this->deck[$index]->toShortString();
     }
  }
  /**
   * Copyright 2017 fukumame
   */
