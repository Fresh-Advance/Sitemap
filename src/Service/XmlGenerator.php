<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\UrlInterface;

class XmlGenerator implements XmlGeneratorInterface
{
    public function generateUrlItem(UrlInterface $url): string
    {
        $attributes = [
            $this->wrap($url->getLocation(), "loc"),
            $this->wrap($url->getLastModified(), "lastmod"),
            $this->wrap($url->getChangeFrequency(), "changefreq"),
            $this->wrap((string)$url->getPriority(), "priority"),
        ];

        return $this->wrap(implode("", $attributes), "url");
    }

    protected function wrap(string $data, string $tag, array $tagAttributes = []): string
    {
        $attributes = '';
        foreach ($tagAttributes as $key => $attributeValue) {
            $attributes .= " {$key}=\"{$attributeValue}\"";
        }

        return "<{$tag}{$attributes}>" . $data . "</{$tag}>";
    }

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
                    "xmlns" => "http://www.sitemaps.org/schemas/sitemap/0.9"
                ]
            );
    }
}
