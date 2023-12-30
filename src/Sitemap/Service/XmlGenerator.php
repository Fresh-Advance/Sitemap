<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Sitemap\Service;

use DateTimeInterface;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrlInterface;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;

class XmlGenerator implements XmlGeneratorInterface
{
    public function generateUrlItem(UrlInterface $url): string
    {
        $attributes = [
            $this->wrap($url->getLocation(), "loc"),
            $this->wrap($url->getLastModified()->format(DateTimeInterface::ATOM), "lastmod"),
            $this->wrap($url->getChangeFrequency(), "changefreq"),
            $this->wrap((string)$url->getPriority(), "priority"),
        ];

        return $this->wrap(implode("", $attributes), "url");
    }

    public function generateSitemapItem(SitemapUrlInterface $url): string
    {
        $attributes = [
            $this->wrap($url->getLocation(), "loc"),
            $this->wrap($url->getLastModified()->format(DateTimeInterface::ATOM), "lastmod"),
        ];

        return $this->wrap(implode("", $attributes), "sitemap");
    }

    protected function wrap(string $data, string $tag, array $tagAttributes = []): string
    {
        $attributes = '';
        foreach ($tagAttributes as $key => $attributeValue) {
            $attributes .= " {$key}=\"{$attributeValue}\"";
        }

        return "<{$tag}{$attributes}>" . $data . "</{$tag}>";
    }

    /**
     * @inheritDoc
     */
    public function generateSitemapDocument(iterable $items): string
    {
        $document = '<?xml version="1.0" encoding="UTF-8"?>';

        $urlBlocks = [];
        foreach ($items as $oneItem) {
            $urlBlocks[] = $this->generateUrlItem($oneItem);
        }

        return $document
            . $this->wrap(
                implode("", $urlBlocks),
                "urlset",
                [
                    "xmlns" => "https://www.sitemaps.org/schemas/sitemap/0.9"
                ]
            );
    }

    /**
     * @inheritDoc
     */
    public function generateSitemapIndexDocument(iterable $items): string
    {
        $document = '<?xml version="1.0" encoding="UTF-8"?>';

        $urlBlocks = [];
        foreach ($items as $oneItem) {
            $urlBlocks[] = $this->generateSitemapItem($oneItem);
        }

        return $document
            . $this->wrap(
                implode("", $urlBlocks),
                "sitemapindex",
                [
                    "xmlns" => "https://www.sitemaps.org/schemas/sitemap/0.9"
                ]
            );
    }
}
