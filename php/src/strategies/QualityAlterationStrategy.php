<?php

declare(strict_types=1);

namespace GildedRose\strategies;

use GildedRose\Item;

/**
 * The Strategy interface declares operations common to all supported versions
 * of some algorithm.
 *
 * The Context uses this interface to call the algorithm defined by Concrete
 * Strategies.
 */
interface QualityAlterationStrategy
{
    /**
     * Alters the quality of an item depending on a strategy
     */
    public function alter(Item &$item): void;
}
