<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use FreshAdvance\Sitemap\Exception\FilterConfigurationException;
use FreshAdvance\Sitemap\Exception\FilterNotFoundException;

class FilterFactory implements FilterFactoryInterface
{
    private array $filters = [];

    /**
     * @param iterable<ChangeFilterInterface> $filters
     */
    public function __construct(
        iterable $filters
    ) {
        foreach ($filters as $oneFilter) {
            if (!$oneFilter instanceof ChangeFilterInterface) {
                throw new FilterConfigurationException();
            }
            $this->filters[$oneFilter->getObjectType()] = $oneFilter;
        }
    }

    public function getFilter(string $objectType): ChangeFilterInterface
    {
        if (!key_exists($objectType, $this->filters)) {
            throw new FilterNotFoundException();
        }

        return $this->filters[$objectType];
    }
}
