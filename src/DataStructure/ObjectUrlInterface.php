<?php

namespace FreshAdvance\Sitemap\DataStructure;

interface ObjectUrlInterface
{
    public function getObjectId(): string;

    public function getObjectType(): string;

    public function getUrl(): UrlInterface;
}
