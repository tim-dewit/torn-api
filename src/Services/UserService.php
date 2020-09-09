<?php

declare(strict_types=1);

namespace Torn\Fetchers;

use Torn\Exceptions\TornException;
use Torn\Services\AbstractService;

class UserService extends AbstractService
{
    const AMMO = 'ammo';
    const ATTACKS = 'attacks';
    const ATTACKS_FULL = 'attacksfull';
    const BARS = 'bars';
    const BASIC = 'basic';
    const BATTLE_STATS = 'battlestats';
    const BAZAAR = 'bazaar';
    const COOLDOWNS = 'cooldowns';
    const CRIMES = 'crimes';
    const DISCORD = 'discord';
    const DISPLAY = 'display';
    const EDUCATION = 'education';
    const EVENTS = 'events';
    const GYM = 'gym';
    const HALL_OF_FAME = 'hof';
    const HONORS = 'honors';
    const ICONS = 'icons';
    const INVENTORY = 'inventory';
    const JOB_POINTS = 'jobpoints';
    const MEDALS = 'medals';
    const MERITS = 'merits';
    const MESSAGES = 'messsages';
    const MONEY = 'money';
    const NET_WORTH = 'networth';
    const NOTIFICATIONS = 'notifications';
    const PERKS = 'perks';
    const PERSONAL_STATS = 'personalstats';
    const PROFILE = 'profile';
    const PROPERTIES = 'properties';
    const RECEIVED_EVENTS = 'receivedevents';
    const REFILLS = 'refills';
    const REVIVES = 'revives';
    const REVIVES_FULL = 'revives_full';
    const STOCKS = 'stocks';
    const TIMESTAMP = 'timestamp';
    const TRAVEL = 'travel';
    const WEAPON_EXP = 'weaponexp';
    const WORK_STATS = 'workstats';

    protected $resourceName = 'user';

    public function isApiKeyValid(string $apiKey): bool
    {
        try {
            $this->fetch('', [], $apiKey);

            return true;
        } catch (TornException $exception) {
            return false;
        }
    }
}
