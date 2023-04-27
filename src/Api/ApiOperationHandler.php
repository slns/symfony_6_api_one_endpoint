<?php

namespace App\Api;

use App\Api\Model\ApiInput;
use App\Api\Model\ApiOutput;
use App\Contract\ApiOperationInterface;
use App\Exception\ApiOperationException;

class ApiOperationHandler
{
    /**
     * @var array<string, ApiOperationInterface> $operations
     */
    private array $operations;

    public function __construct(iterable $apiOperations)
    {
        foreach ($apiOperations as $operation){
            $this->operations[$operation->getName()] = $operation;
        }
    }

    public function performOperation(ApiInput $apiInput): ApiOutput
    {
        if(!isset($this->operations[$apiInput->getOperation()])){
            throw new ApiOperationException([], sprintf('Operation %s is not defined', $apiInput->getOperation()));
        }

        return $this->operations[$apiInput->getOperation()]->perform($apiInput);
    }
}
