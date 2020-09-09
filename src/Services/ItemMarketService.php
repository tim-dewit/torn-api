<?php

declare(strict_types=1);

namespace Torn\Services;

class ItemMarketService extends AbstractService
{
    const BAZAAR = 'bazaar';
    const ITEM_MARKET = 'itemmarket';
    const POINTS_MARKET = 'pointsmarket';

    protected $resourceName = 'market';
}
