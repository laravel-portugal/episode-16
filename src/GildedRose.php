<?php

class GildedRose {

    private $items;

    function __construct($items) 
    {
        $this->items = $items;
    }

    function onDayHasPassed() 
    {
        foreach ($this->items as $item) {
            $item->updateQuality();
        }
    }

}

interface ShopItem {

    public function updateQuality();

    public function isExpired();

    public function onDayHasPassed();

}

class Item implements ShopItem {

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

    public function isExpired()
    {
        return $this->sellIn < 0;
    }

    public function onDayHasPassed()
    {
        $this->sellIn--;
    }

    public function addQuality($quality = 1)
    {
        $this->quality = $this->quality + $quality;

        $this->quality = min($this->quality, 50);
        $this->quality = max($this->quality, 0);
    }

    public function __toString() 
    {
        return "{$this->name}, {$this->sellIn}, {$this->quality}";
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

    public function updateQuality() 
    {
        $this->onDayHasPassed();
        
        switch(true) {
            case $this->isExpired():
                $this->quality = 0;
                break;
            case $this->sellIn <= 5:
                $this->addQuality(3);
                break;
            case $this->sellIn <= 10:
                $this->addQuality(2);
                break;
            default:  
                $this->addQuality(1);
        }
    }

}

class ConjuredItem extends Item {

    public function updateQuality() {
        $this->onDayHasPassed();
        
        if ($this->isExpired()) {
            $this->addQuality(-4);
        } else {
            $this->addQuality(-2);
        }
    }

}