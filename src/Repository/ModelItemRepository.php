<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Repository;

use FreshAdvance\Sitemap\Exception\ModelItemNotFoundException;
use OxidEsales\Eshop\Core\Contract\IUrl;
use OxidEsales\Eshop\Core\Model\BaseModel;

class ModelItemRepository implements ModelItemRepositoryInterface
{
    public function __construct(
        protected string $model
    ) {
    }

    public function getItem(string $identifier): BaseModel
    {
        $item = oxNew($this->model);
        if (!$item->load($identifier)) {
            throw new ModelItemNotFoundException();
        }

        return $item;
    }
}
