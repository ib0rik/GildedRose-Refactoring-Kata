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

        $operand = 1;

        if ($item->sell_in < 5) {
            $operand = 3;
        } elseif ($item->sell_in < 10) {
            $operand = 2;
        }

        $item->quality += $operand;

        //check
        if ($item->quality > MAX_NORMAL_ITEM_QUALITY) {
            $item->quality = MAX_NORMAL_ITEM_QUALITY;
        }
    }
}
