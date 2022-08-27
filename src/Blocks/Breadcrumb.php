<?php

namespace Notion\Blocks;

use Notion\Blocks\Exceptions\BlockException;

/**
 * @psalm-import-type BlockMetadataJson from BlockMetadata
 *
 * @psalm-type BreadcrumbJson = array{
 *      breadcrumb: array<empty, empty>
 * }
 *
 * @psalm-immutable
 */
class Breadcrumb implements BlockInterface
{
    private function __construct(
        private readonly BlockMetadata $metadata
    ) {
        $metadata->checkType(BlockType::Breadcrumb);
    }

    public static function create(): self
    {
        $metadata = BlockMetadata::create(BlockType::Breadcrumb);

        return new self($metadata);
    }

    public static function fromArray(array $array): self
    {
        /** @psalm-var BlockMetadataJson $array */
        $metadata = BlockMetadata::fromArray($array);

        return new self($metadata);
    }

    public function toArray(): array
    {
        $array = $this->metadata->toArray();

        $array["breadcrumb"] = new \stdClass();

        return $array;
    }

    public function toUpdateArray(): array
    {
        return [
            "breadcrumb" => new \stdClass(),
            "archived"   => $this->metadata()->archived,
        ];
    }

    public function metadata(): BlockMetadata
    {
        return $this->metadata;
    }

    public function addChild(BlockInterface $child): self
    {
        throw BlockException::noChindrenSupport();
    }

    public function changeChildren(BlockInterface ...$children): self
    {
        throw BlockException::noChindrenSupport();
    }

    public function archive(): BlockInterface
    {
        return new self($this->metadata->archive());
    }
}
