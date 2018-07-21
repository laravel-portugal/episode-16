<?php

class GildedRose {

    private $items;

    function __construct($items) 
    {
        $this->items = $items;
    }

    public function onDayHasPassed() 
    {
        foreach ($this->items as $item) {
            $item->updateQuality();
        }
    }

}

interface ShopItem {

    public function updateQuality();

}

class Item implements ShopItem {

    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;

    public $name;
    public $sellIn;
    public $quality;

    function __construct($name, $sellIn, $quality) 
    {
        $this->name = $name;
        $this->sellIn = $sellIn;
        $this->quality = $quality;
    }

    public function updateQuality()
    {
        $this->onDayHasPassed();

        if ($this->isExpired()) {
            $this->addQuality(-2);
        } else {
            $this->addQuality(-1);
        }
    }

    public function __toString() 
    {
        return "{$this->name}, {$this->sellIn}, {$this->quality}";
    }

    protected function isExpired()
    {
        return $this->sellIn < 0;
    }

    protected function onDayHasPassed()
    {
        $this->sellIn--;
    }

    protected function addQuality($quality = 1)
    {
        $this->quality = $this->quality + $quality;

        $this->quality = min($this->quality, self::MAX_QUALITY);
        $this->quality = max($this->quality, self::MIN_QUALITY);
    }

}

class LegendaryItem extends Item implements ShopItem {

    public function updateQuality() { }

}

class RefiningItem extends Item implements ShopItem {

    public function updateQuality() 
    {
        $this->onDayHasPassed();
        
        if ($this->isExpired()) {
            $this->addQuality(2);
        } else {
            $this->addQuality(1);
        }
    }

}

class ConcertTicketItem extends Item {

    const DAYS_DOUBLE_RATE = 10;
    const DAYS_TRIPLE_RATE = 5;

    public function updateQuality() 
    {
        $this->onDayHasPassed();
        
        switch(true) {
            case $this->isExpired():
                $this->quality = 0;
                break;
            case $this->sellIn <= self::DAYS_TRIPLE_RATE:
                $this->addQuality(3);
                break;
            case $this->sellIn <= self::DAYS_DOUBLE_RATE:
                $this->addQuality(2);
                break;
            default:  
                $this->addQuality(1);
        }
    }

}

class ConjuredItem extends Item {

    public function updateQuality() 
    {
        $this->onDayHasPassed();
        
        if ($this->isExpired()) {
            $this->addQuality(-4);
        } else {
            $this->addQuality(-2);
        }
    }

}