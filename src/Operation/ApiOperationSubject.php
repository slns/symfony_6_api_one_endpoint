<?php

namespace App\Operation;

class ApiOperationSubject
{
    private string $operation;
    private ?string $group = null;

    public function __construct(string $operation, ?string $group)
    {
        $this->operation = $operation;
        $this->group = $group;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }
}
