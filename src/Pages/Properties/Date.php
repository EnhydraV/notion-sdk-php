<?php

namespace Notion\Pages\Properties;

use DateTimeImmutable;
use Notion\Common\Date as CommonDate;

/**
 * @psalm-type DateJson = array{
 *      id: string,
 *      type: "date",
 *      date: array{
 *          start: string,
 *          end?: string,
 *      },
 * }
 *
 * @psalm-immutable
 */
class Date implements PropertyInterface
{
    private function __construct(
        private readonly PropertyMetadata $metadata,
        public readonly CommonDate $date,
    ) {
    }

    public static function create(DateTimeImmutable $date): self
    {
        $property = PropertyMetadata::create("", PropertyType::Date);

        return new self($property, CommonDate::create($date));
    }

    public static function createRange(DateTimeImmutable $start, DateTimeImmutable $end): self
    {
        $property = PropertyMetadata::create("", PropertyType::Date);

        return new self($property, CommonDate::createRange($start, $end));
    }

    public static function fromArray(array $array): self
    {
        /** @psalm-var DateJson $array */

        $property = PropertyMetadata::fromArray($array);

        $date = CommonDate::fromArray($array["date"]);

        return new self($property, $date);
    }

    public function toArray(): array
    {
        $array = $this->metadata->toArray();

        $array["date"] = $this->date->toArray();

        return $array;
    }

    public function metadata(): PropertyMetadata
    {
        return $this->metadata;
    }

    public function changeStart(DateTimeImmutable $start): self
    {
        return new self($this->metadata, $this->date->changeStart($start));
    }

    public function changeEnd(DateTimeImmutable $end): self
    {
        return new self($this->metadata, $this->date->changeEnd($end));
    }

    public function removeEnd(): self
    {
        return new self($this->metadata, $this->date->removeEnd());
    }

    public function start(): DateTimeImmutable
    {
        return $this->date->start;
    }

    public function end(): DateTimeImmutable|null
    {
        return $this->date->end;
    }

    public function isRange(): bool
    {
        return $this->date->isRange();
    }
}
