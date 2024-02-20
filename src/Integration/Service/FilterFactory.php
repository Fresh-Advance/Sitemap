<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Integration\Service;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;
use FreshAdvance\Sitemap\Integration\Exception\FilterConfigurationException;
use FreshAdvance\Sitemap\Integration\Exception\FilterNotFoundException;

class FilterFactory implements FilterFactoryInterface
{
    private array $filters = [];

    /**
     * @param iterable<\FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface> $filters
     */
    public function __construct(
        iterable $filters
    ) {
        foreach ($filters as $oneFilter) {
            if (!$oneFilter instanceof ChangeFilterInterface) {
                throw new FilterConfigurationException($oneFilter::class);
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

    public function getFilters(): array
    {
        return $this->filters;
    }
}
