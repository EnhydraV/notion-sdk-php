<?php

namespace Notion\Pages\Properties;

/**
 * @psalm-type UrlJson = array{
 *      id: string,
 *      type: "url",
 *      url: string,
 * }
 *
 * @psalm-immutable
 */
class Url implements PropertyInterface
{
    private function __construct(
        private readonly PropertyMetadata $metadata,
        public readonly string $url
    ) {
    }

    public static function create(string $url): self
    {
        $metadata = PropertyMetadata::create("", PropertyType::Url);

        return new self($metadata, $url);
    }

    public static function fromArray(array $array): self
    {
        /** @psalm-var UrlJson $array */

        $metadata = PropertyMetadata::fromArray($array);

        $url = $array["url"];

        return new self($metadata, $url);
    }

    public function toArray(): array
    {
        $array = $this->metadata->toArray();

        $array["url"] = $this->url;

        return $array;
    }

    public function metadata(): PropertyMetadata
    {
        return $this->metadata;
    }

    public function changeUrl(string $url): self
    {
        return new self($this->metadata, $url);
    }
}
