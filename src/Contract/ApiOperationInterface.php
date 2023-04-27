<?php

namespace App\Contract;

use App\Api\Model\ApiInput;
use App\Api\Model\ApiOutput;

interface ApiOperationInterface
{
    public function perform(ApiInput $apiInput): ApiOutput;
    public function getName(): string;
    public function getInput(): string;
}
