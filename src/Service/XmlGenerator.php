<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;

class XmlGenerator implements XmlGeneratorInterface
{
    public function generateUrlItem(PageUrlInterface $url): string
    {
        $attributes = [
            $this->wrap($url->getLocation(), "loc"),
            $this->wrap($url->getLastModified(), "lastmod"),
            $this->wrap($url->getChangeFrequency(), "changefreq"),
            $this->wrap((string)$url->getPriority(), "priority"),
        ];

        return $this->wrap(implode("", $attributes), "url");
    }

    public function generateSitemapItem(SitemapUrlInterface $url): string
    {
        $attributes = [
            $this->wrap($url->getLocation(), "loc"),
            $this->wrap($url->getLastModified(), "lastmod"),
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
