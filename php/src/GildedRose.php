<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\enum\ItemName;
use GildedRose\strategies\CheeseStrategy;
use GildedRose\strategies\ConcertTicketStrategy;
use GildedRose\strategies\ExpirationDateStrategy;

define('MAX_NORMAL_ITEM_QUALITY', 50);
define('MIN_NORMAL_ITEM_QUALITY', 0);
define('MAX_LEGENDARY_ITEM_QUALITY', 80);
define('MIN_LEGENDARY_ITEM_QUALITY', 80);

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        $strategy = null;

        foreach ($this->items as $item) {
            switch ($item->name) {

                case ItemName::AGED_BRIE:
                    $strategy = new CheeseStrategy();
                    break;

                case ItemName::BACKSTAGE_PASSES:
                    $strategy = new ConcertTicketStrategy();
                    break;

                case ItemName::SULFURAS:
                    $strategy = null;
                    break;

                case ItemName::CONJURED:
                    $strategy = new ExpirationDateStrategy(2);
                    break;

                default:
                    $strategy = new ExpirationDateStrategy();
            }

            if ($strategy) {
                $strategy->alter($item);
            }
        }
    }
}
