<?php

require_once 'GildedRose.php';

class GildedRoseTest extends PHPUnit\Framework\TestCase {

    function test_quality_drops_each_day() {
        $items = [
            $itemA = new Item('Apple', 5, 15),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(14, $itemA->quality);
    }

    function test_quality_drops_twice_as_fast_when_sell_date_is_0() {
        $items = [
            $itemA = new Item('Apple', 0, 15),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(13, $itemA->quality);
    }

    function test_quality_never_drops_to_negative() {
        $items = [
            $itemA = new Item('Apple', 0, 0),
            $itemB = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 0, 0),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(0, $itemA->quality);
        $this->assertEquals(0, $itemB->quality);
    }

    function test_sulfuras_never_drops_quality() {
        $items = [
            $itemA = new LegendaryItem('Sulfuras, Hand of Ragnaros', 0, 80),
            $itemB = new LegendaryItem('Sulfuras, Hand of Ragnaros', -1, 80),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(80, $itemA->quality);
        $this->assertEquals(80, $itemB->quality);
    }

    function test_aged_brie_increases_in_quality() {
        $items = [
            $item = new RefiningItem('Aged Brie', 4, 30),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(31, $item->quality);
    }

    function test_aged_brie_increases_in_quality_twice_as_fast_when_sell_date_is_0() {
        $items = [
            $item = new RefiningItem('Aged Brie', 0, 30),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(32, $item->quality);
    }

    function test_concert_tickets_increases_in_quality() {
        $items = [
            $item = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 12, 10),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(11, $item->quality);
    }

    function test_concert_tickets_increases_in_quality_twice_as_fast_when_concert_date_is_less_than_or_10_days() {
        $items = [
            $item = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 10, 10),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(12, $item->quality);
    }

    function test_concert_tickets_increases_in_quality_thrice_as_fast_when_concert_date_is_less_than_or_5_days() {
        $items = [
            $item = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 5, 10),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(13, $item->quality);
    }

    function test_concert_tickets_quality_is_0_when_concert_date_has_passed() {
        $items = [
            $itemA = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 0, 10),
            $itemB = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', -1, 10),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(0, $itemA->quality);
        $this->assertEquals(0, $itemB->quality);
    }

    function test_quality_never_increases_more_than_50() {
        $items = [
            $itemA = new RefiningItem('Aged Brie', 1, 50),
            $itemB = new RefiningItem('Aged Brie', 0, 50),
            $itemC = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 15, 50),
            $itemD = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 10, 50),
            $itemE = new ConcertTicketItem('Backstage passes to a TAFKAL80ETC concert', 5, 50),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->onDayHasPassed();

        $this->assertEquals(50, $itemA->quality);
        $this->assertEquals(50, $itemB->quality);
        $this->assertEquals(50, $itemC->quality);
        $this->assertEquals(50, $itemD->quality);
        $this->assertEquals(50, $itemE->quality);
    }

    // function test_conjured_items_quality_drops_twice_as_fast_each_day() {
    //     $items = [
    //         $itemA = new Item('Conjured Mana Cake', 5, 15),
    //     ];

    //     $gildedRose = new GildedRose($items);
    //     $gildedRose->onDayHasPassed();

    //     $this->assertEquals(13, $itemA->quality);
    // }

    // function test_conjured_items_quality_drops_twice_as_fast_when_sell_date_is_0() {
    //     $items = [
    //         $itemA = new Item('Conjured Mana Cake', 0, 15),
    //     ];

    //     $gildedRose = new GildedRose($items);
    //     $gildedRose->onDayHasPassed();

    //     $this->assertEquals(11, $itemA->quality);
    // }

}