<?php

namespace App\Api;

use App\Exception\ApiOperationException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiOperationInputHandler
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

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
