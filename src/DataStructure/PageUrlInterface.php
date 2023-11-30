<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\DataStructure;

interface PageUrlInterface
{
    public function getLocation(): string;

    public function getLastModified(): \DateTimeInterface;

    public function getChangeFrequency(): string;

    public function getPriority(): float;
}
