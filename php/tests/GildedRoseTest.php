<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\enum\ItemName;
use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testNormalItemKeepsIncrementing(): void
    {
        $days = 3;

        $items = [new Item(ItemName::NORMAL, $days, $days)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(0, $items[0]->sell_in);
    }

    public function testNoNegativeQuality(): void
    {
        $days = 3;

        $sell_in = $quality = $days - 2;

        $items = $this->getAllItemType($sell_in, $quality);
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $this->assertGreaterThanOrEqual(0, $items[0]->quality);
    }

    public function testNoMoreMaxQuality(): void
    {
        $days = MAX_NORMAL_ITEM_QUALITY + 5;

        $items = $this->getAllItemType(0, 0, [ItemName::SULFURAS]);
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $this->assertLessThanOrEqual(MAX_NORMAL_ITEM_QUALITY, $items[0]->quality);
        $this->assertSame(-1 * $days, $items[0]->sell_in);
    }

    public function testNoAlterationToSulfuras(): void
    {
        $days = 80;

        $sell_in = -1;
        $quality = 80;

        $items = [new Item(ItemName::SULFURAS, $sell_in, $quality)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $this->assertSame($quality, $items[0]->quality);
        $this->assertSame($sell_in, $items[0]->sell_in);
    }

    public function testQualityDegradesTwiceWhenDatePassed(): void
    {
        $normalStep = 2; //Quality degrades by 1
        $specialStep = 1; //Quality degrades by 2

        $days = $normalStep + $specialStep;

        //values
        $sell_in = $normalStep;
        $quality = $normalStep + ($specialStep * 2);

        $items = [new Item(ItemName::NORMAL, $sell_in, $quality)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        //sell_in should be negative
        //and quality should be equal to zero
        $this->assertSame($sell_in - $days, $items[0]->sell_in);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testAgedBrieQualityKeepsIncreasing(): void
    {
        $days = 3;

        $items = [new Item(ItemName::AGED_BRIE, $days, 0)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $this->assertSame($days, $items[0]->quality);
        $this->assertSame(0, $items[0]->sell_in);
    }

    public function testAgedBrieQualityIncreasesBy2WhenDatePassed(): void
    {
        $days = 3;

        $sell_in = $days - 1;

        $items = [new Item(ItemName::AGED_BRIE, $sell_in, 0)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $this->assertSame($sell_in + ($days - $sell_in) * 2, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sell_in);
    }

    public function testBackstageQualityIncreasesByRemainingDays(): void
    {
        $add1Steps = 5;
        $add2Steps = 5;
        $add3Steps = 5;

        $days = $add1Steps + $add2Steps + $add3Steps;

        $items = [new Item(ItemName::BACKSTAGE_PASSES, $days, 0)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        $expected_quality = $add1Steps + ($add2Steps * 2) + ($add3Steps * 3);
        $this->assertSame($expected_quality, $items[0]->quality);

        //after concert
        $app->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    public function testConjuredQualityDegradesTwiceThanNormal(): void
    {
        $normalStep = 2; //Quality degrades by 2
        $specialStep = 1; //Quality degrades by 4

        $days = $normalStep + $specialStep;

        //values
        $sell_in = $normalStep;
        $quality = ($normalStep * 2) + ($specialStep * 4);

        $items = [new Item(ItemName::CONJURED, $sell_in, $quality)];
        $app = new GildedRose($items);

        for ($i = 0; $i < $days; $i++) {
            $app->updateQuality();
        }

        //sell_in should be negative
        //and quality should be equal to zero
        $this->assertSame($sell_in - $days, $items[0]->sell_in);
        $this->assertSame(0, $items[0]->quality);
    }

    /**
     * Generates an array of all different item's names.
     * @return Item[]
     */
    private function getAllItemType(int $sell_in, int $quality, array $except = []): array
    {
        $result = [];

        $itemNames = [
            ItemName::CONJURED,
            ItemName::SULFURAS,
            ItemName::BACKSTAGE_PASSES,
            ItemName::AGED_BRIE,
            ItemName::NORMAL,
        ];

        foreach ($itemNames as $name) {
            if (in_array($name, $except, true)) {
                continue;
            }
            array_push($result, new Item($name, $sell_in, $quality));
        }

        return $result;
    }
}
