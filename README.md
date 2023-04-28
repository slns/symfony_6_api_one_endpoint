# symfony 6 api_one_endpoint

Api one endpoint bundle allows you to create an api focusing on operations instead of resources. One endpoint is used as a resource and api looks into payload to extract what operation has to perform and what data needs to perform it.


### Start server 

> symfony server:start


## 1ª Parte
### Another way to define api operations
In this case, operation to perform will be sent within the payload request. As requests arrives to api, it looks into the payload, detects the operation to perform and executes it passing to the operation handler the rest of the data which comes on the payload.

> [Code in GitHub](https://github.com/slns/symfony_6_api_one_endpoint/commit/a954087b11c24f4302bc6191f431a9a48749d657)

## 2ª Parte
### Security to our api in two ways

- We will authenticate through a token included in request http headers.
- We will protect operations access using authorization checkings

> [Code in GitHub](https://github.com/slns/symfony_6_api_one_endpoint/commit/)
