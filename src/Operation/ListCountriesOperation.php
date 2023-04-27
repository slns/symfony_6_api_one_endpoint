<?php

namespace App\Operation;

use App\Api\ApiOperationInputHandler;
use App\Api\Model\ApiInput;
use App\Api\Model\ApiOutput;
use App\Api\Model\Operation\ListCountriesInput;
use App\Contract\ApiOperationInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class ListCountriesOperation implements ApiOperationInterface
{
    private ApiOperationInputHandler $apiOperationInputHandler;
    private KernelInterface $kernel;

    public function __construct(ApiOperationInputHandler $apiOperationInputHandler, KernelInterface $kernel)
    {
        $this->apiOperationInputHandler = $apiOperationInputHandler;
        $this->kernel = $kernel;
    }

    public function perform(ApiInput $apiInput): ApiOutput
    {
        /**
         * @var ListCountriesInput $inputObject
         */
        $inputObject = $this->apiOperationInputHandler->denormalizeAndValidate($apiInput->getData(), $this->getInput());
        $countries   = json_decode(file_get_contents($this->kernel->getProjectDir() . '/data/countries.json'), true);

        $targetCountries = array_values(array_map(
            fn(array $countryData) => ['iso2' => strtoupper($countryData['alpha2']), 'name' => $countryData[$inputObject->getLanguage()]],
            $countries
        ));

        if(!empty($inputObject->getName())){
            $targetCountries = array_values(
                array_filter(
                    $targetCountries,
                    fn(array $targetCountry) => str_contains($targetCountry['name'], $inputObject->getName())
                )
            );
        }

        if(!empty($inputObject->getIso2())){
            $targetCountries = array_values(
                array_filter(
                    $targetCountries,
                    fn(array $targetCountry) => $targetCountry['iso2'] === $inputObject->getIso2()
                )
            );
        }

        return new ApiOutput($targetCountries, Response::HTTP_OK);
    }

    public function getName(): string
    {
        return 'ListCountriesOperation';
    }

    public function getInput(): string
    {
        return ListCountriesInput::class;
    }
}
