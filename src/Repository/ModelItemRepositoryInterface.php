<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Repository;

use OxidEsales\Eshop\Core\Model\BaseModel;

interface ModelItemRepositoryInterface
{
    public function getItem(string $identifier): BaseModel;
}
