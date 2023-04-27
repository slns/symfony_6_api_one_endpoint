<?php

namespace App\Controller;

use App\Api\ApiOperationHandler;
use App\Api\Model\ApiInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ApiController extends AbstractController
{
    #[Route('/api/v1/operation', name: 'api_operation', methods: ['POST'])]
    public function apiOperationAction(Request $request, SerializerInterface $serializer, ApiOperationHandler $apiOperationHandler): JsonResponse
    {
        $apiInput = $serializer->deserialize($request->getContent(), ApiInput::class, 'json');
        $apiOutput = $apiOperationHandler->performOperation($apiInput);

        return new JsonResponse(
            $serializer->normalize($apiOutput->getData()),
            $apiOutput->getCode()
        );
    }
}
