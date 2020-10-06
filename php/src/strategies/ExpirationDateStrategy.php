<?php

declare(strict_types=1);

namespace GildedRose\strategies;

use GildedRose\Item;

class ExpirationDateStrategy implements QualityAlterationStrategy
{
    /**
     * The decreasing factor to apply
     *
     * Example:
     *
     * Factor = 1
     *      before date passed -> quality is degrading by 1*1
     *      after date passed -> quality is degrading by 2*1
     *
     * Factor = 2
     *      before date passed -> quality is degrading by 1*2
     *      after date passed -> quality is degrading by 2*2
     *
     * @var int
     */
    private $factor;

    public function __construct(int $factor = 1)
    {
        $this->factor = $factor;
    }

    public function alter(Item &$item): void
    {
        $item->sell_in--;

        $operand = 1;

        if ($item->sell_in < 0) {
            $operand = 2;
        }

        $operand *= $this->factor;

        $item->quality -= $operand;

        //check
        if ($item->quality < MIN_NORMAL_ITEM_QUALITY) {
            $item->quality = MIN_NORMAL_ITEM_QUALITY;
        }
    }
}
