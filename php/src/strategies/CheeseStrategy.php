<?php

declare(strict_types=1);

namespace GildedRose\strategies;

use GildedRose\Item;

class CheeseStrategy implements QualityAlterationStrategy
{
    /**
     * As for a cheese, the quality increases the older it gets.
     */
    public function alter(Item &$item): void
    {
        $item->sell_in--;

        $item->quality++;

        if ($item->sell_in < 0) {
            $item->quality++;
        }

        //check
        if ($item->quality > MAX_NORMAL_ITEM_QUALITY) {
            $item->quality = MAX_NORMAL_ITEM_QUALITY;
        }
    }
}
