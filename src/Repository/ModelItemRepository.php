<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Repository;

use FreshAdvance\Sitemap\Integration\Exception\ModelItemNotFoundException;
use OxidEsales\Eshop\Core\Contract\IUrl;
use OxidEsales\Eshop\Core\Model\BaseModel;

class ModelItemRepository implements ModelItemRepositoryInterface
{
    /**
     * @param class-string $model
     */
    public function __construct(
        protected string $model
    ) {
    }

    public function getItem(string $identifier): BaseModel
    {
        /** @var BaseModel&IUrl $item */
        $item = oxNew($this->model);
        if (!$item->load($identifier)) {
            throw new ModelItemNotFoundException();
        }

        return $item;
    }
}
