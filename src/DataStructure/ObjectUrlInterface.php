<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\DataStructure;

interface ObjectUrlInterface
{
    public function getObjectId(): string;

    public function getObjectType(): string;

    public function getUrl(): PageUrlInterface;
}
