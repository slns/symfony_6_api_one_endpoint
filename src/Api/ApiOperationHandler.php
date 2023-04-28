<?php

namespace App\Api;

use App\Api\Model\ApiInput;
use App\Api\Model\ApiOutput;
use App\Contract\ApiOperationInterface;
use App\Exception\ApiOperationException;
use App\Operation\ApiOperationSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ApiOperationHandler
{
    /**
     * @var array<string, ApiOperationInterface> $operations
     */
    private array $operations;

    public function __construct(private readonly Security $security, iterable $apiOperations)
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

        $operationHandler = $this->operations[$apiInput->getOperation()];
        if(!$this->security->isGranted('EXECUTE_OPERATION', new ApiOperationSubject(get_class($operationHandler), $operationHandler->getGroup()))){
            throw new AccessDeniedException('Not allowed to perform this operation');
        }

        return $operationHandler->perform($apiInput);
    }
}
