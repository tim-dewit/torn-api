<?php

declare(strict_types=1);

namespace Torn\Services;

class TornService extends AbstractService
{
    const BANK = 'bank';
    const COMPANIES = 'companies';
    const COMPETITION = 'competition';
    const EDUCATION = 'education';
    const FACTION_TREE = 'factiontree';
    const GYMS = 'gyms';
    const HONORS = 'honors';
    const ITEMS = 'items';
    const MEDALS = 'medals';
    const ORGANISED_CRIMES = 'organisedcrimes';
    const PAWN_SHOP = 'pawnshop';
    const PROPERTIES = 'properties';
    const RACKETS = 'rackets';
    const RAIDS = 'raids';
    const STATS = 'stats';
    const STOCKS = 'stocks';
    const TERRITORY = 'territory';
    const TERRITORY_WARS = 'territorywars';

    protected $resourceName = 'torn';
}
