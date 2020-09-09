<?php

declare(strict_types=1);

namespace Torn\Services;

class FactionService extends AbstractService
{
    const APPLICATIONS = 'applications';
    const ARMOR = 'armor';
    const ARMORY_NEWS = 'armorynews';
    const ARMORY_NEWS_FULL = 'armorynewsfull';
    const ATTACK_NEWS = 'attacknews';
    const ATTACK_NEWS_FULL = 'attacknewsfull';
    const ATTACKS = 'attacks';
    const ATTACKS_FULL = 'attacksfull';
    const BASIC = 'basic';
    const BOOSTERS = 'boosters';
    const CESIUM = 'cesium';
    const CHAIN = 'chain';
    const CHAINS = 'chains';
    const CONTRIBUTORS = 'contributors';
    const CRIME_NEWS = 'crimenews';
    const CRIME_NEWS_FULL = 'crimenewsfull';
    const CRIMES = 'crimes';
    const CURRENCY = 'currency';
    const DONATIONS = 'donations';
    const DRUGS = 'drugs';
    const FUNDS_NEWS = 'fundsnews';
    const FUNDS_NEWS_FULL = 'fundsnewsfull';
    const MAIN_NEWS = 'mainnews';
    const MAIN_NEWS_FULL = 'mainnewsfull';
    const MEDICAL = 'medical';
    const MEMBERSHIP_NEWS = 'membershipnews';
    const MEMBERSHIP_NEWS_FULL = 'membershipnewsfull';
    const REVIVES = 'revives';
    const REVIVES_FULL = 'revivesfull';
    const STATS = 'stats';
    const TEMPORARY = 'temporary';
    const TERRITORY = 'territory';
    const UPGRADES = 'upgrades';
    const WEAPONS = 'weapons';

    protected $resourceName = 'faction';
}
