<?php

namespace App\Api;

use App\Exception\ApiOperationException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiOperationInputHandler
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface  $validator
    ) {}

    public function denormalizeAndValidate(array $input, string $className): object
    {
        $denormalizedObject = $this->serializer->denormalize($input, $className);
        $validationErrors   = $this->validator->validate($denormalizedObject);
        if(count($validationErrors) > 0){
            $errors = [];
            foreach ($validationErrors as $error){
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new ApiOperationException($errors);
        }

        return $denormalizedObject;
    }
}
