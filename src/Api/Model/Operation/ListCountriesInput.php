<?php

namespace App\Api\Model\Operation;

use Symfony\Component\Validator\Constraints as Assert;

class ListCountriesInput
{
    private ?string $name = null;

    #[Assert\Regex('/[A-Z]{2}/', message: 'Iso2 must be valid')]
    private ?string $iso2 = null;

    #[Assert\Regex('/[a-z]{2}/', message: 'Language must have only two chars. Example: es, it, pt, fr, en ...')]
    #[Assert\NotBlank(message: 'Language cannot be empty')]
    private string $language;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    public function setIso2(?string $iso2): void
    {
        $this->iso2 = $iso2;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }
}
