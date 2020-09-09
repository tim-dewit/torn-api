<?php

declare(strict_types=1);

namespace Torn\Services;

class CompanyService extends AbstractService
{
    const APPLICATIONS = 'applications';
    const DETAILED = 'detailed';
    const EMPLOYEES = 'employees';
    const NEWS = 'news';
    const NEWS_FULL = 'newsfull';
    const PROFILE = 'profile';
    const STOCK = 'stock';

    protected $resourceName = 'company';
}
