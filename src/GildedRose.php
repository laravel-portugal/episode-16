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
        $this->sellIn--;

        if ($this->sellIn < 0) {
            $this->quality = $this->quality - 2;
        } else {
            $this->quality = $this->quality - 1;
        }

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
        $this->sellIn--;
        
        if ($this->sellIn < 0) {
            $this->quality = $this->quality + 2;
        } else {
            $this->quality = $this->quality + 1;
        }

        $this->quality = min($this->quality, 50);
    }

}

class ConcertTicketItem extends Item {

    public function updateQuality() 
    {
        $this->sellIn--;
        
        switch(true) {
            case $this->sellIn < 0:
                $this->quality = 0;
                break;
            case $this->sellIn <= 5:
                $this->quality = $this->quality + 3;
                break;
            case $this->sellIn <= 10:
                $this->quality = $this->quality + 2;
                break;
            default:
                $this->quality = $this->quality + 1;
        }
        
        $this->quality = min($this->quality, 50);
    }

}