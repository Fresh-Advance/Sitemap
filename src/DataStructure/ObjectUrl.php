<?php

namespace FreshAdvance\Sitemap\DataStructure;

class ObjectUrl implements ObjectUrlInterface
{
    public function __construct(
        private string $objectId,
        private string $objectType,
        private UrlInterface $url
    ) {
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    public function getUrl(): UrlInterface
    {
        return $this->url;
    }
}
