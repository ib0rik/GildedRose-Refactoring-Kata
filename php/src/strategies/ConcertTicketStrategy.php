<?php

declare(strict_types=1);

namespace GildedRose\strategies;

use GildedRose\Item;

class ConcertTicketStrategy implements QualityAlterationStrategy
{
    public function alter(Item &$item): void
    {
        $item->sell_in--;

        //check
        if ($item->sell_in < 0) {
            $item->quality = MIN_NORMAL_ITEM_QUALITY;
            return;
        }

        $item->quality++;

        if ($item->sell_in < 10) {
            $item->quality++;
        }
        
        if ($item->sell_in < 5) {
            $item->quality++;
        }

        //check
        if ($item->quality > MAX_NORMAL_ITEM_QUALITY) {
            $item->quality = MAX_NORMAL_ITEM_QUALITY;
        }
    }
}
