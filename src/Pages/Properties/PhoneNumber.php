<?php

namespace Notion\Pages\Properties;

/**
 * @psalm-type PhoneNumberJson = array{
 *      id: string,
 *      type: "phone_number",
 *      phone_number: string,
 * }
 *
 * @psalm-immutable
 */
class PhoneNumber implements PropertyInterface
{
    private function __construct(
        private readonly PropertyMetadata $metadata,
        public readonly string $phone
    ) {
    }

    public static function create(string $phone): self
    {
        $property = PropertyMetadata::create("", PropertyType::PhoneNumber);

        return new self($property, $phone);
    }

    public static function fromArray(array $array): self
    {
        /** @psalm-var PhoneNumberJson $array */

        $property = PropertyMetadata::fromArray($array);

        $phone = $array["phone_number"];

        return new self($property, $phone);
    }

    public function toArray(): array
    {
        $array = $this->metadata->toArray();

        $array["phone_number"] = $this->phone;

        return $array;
    }

    public function metadata(): PropertyMetadata
    {
        return $this->metadata;
    }

    public function changePhone(string $phone): self
    {
        return new self($this->metadata, $phone);
    }
}
