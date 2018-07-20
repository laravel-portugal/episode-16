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

class Item {

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
        if ($this->name != 'Sulfuras, Hand of Ragnaros') {
            $this->sellIn--;
        }

        if ($this->name == 'Aged Brie' || $this->name == 'Backstage passes to a TAFKAL80ETC concert') {
            if ($this->quality < 50) {
                $this->quality = $this->quality + 1;
                if ($this->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($this->sellIn < 11) {
                        if ($this->quality < 50) {
                            $this->quality = $this->quality + 1;
                        }
                    }
                    if ($this->sellIn < 6) {
                        if ($this->quality < 50) {
                            $this->quality = $this->quality + 1;
                        }
                    }
                }
            }

            if ($this->sellIn < 0) {
                if ($this->name == 'Aged Brie') {
                    if ($this->quality < 50) {
                        $this->quality = $this->quality + 1;
                    }
                }

                if ($this->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    $this->quality = 0;
                }
            }
        } else {
            if ($this->name != 'Sulfuras, Hand of Ragnaros') {
                if ($this->sellIn < 0) {
                    $this->quality = $this->quality - 2;
                } else {
                    $this->quality = $this->quality - 1;
                }
        
                $this->quality = max($this->quality, 0);
            }
        }
    }

    public function __toString() 
    {
        return "{$this->name}, {$this->sellIn}, {$this->quality}";
    }

}