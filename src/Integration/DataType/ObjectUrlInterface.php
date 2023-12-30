<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Integration\DataType;

use DateTimeInterface;

interface ObjectUrlInterface
{
    public function getObjectId(): string;

    public function getObjectType(): string;

    public function getLocation(): string;

    public function getModified(): DateTimeInterface;
}
