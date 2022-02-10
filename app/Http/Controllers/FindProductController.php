<?php

namespace App\Http\Controllers;

use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Model\Request\Store\ProductsRequest;
use \RetailCrm\Api\Model\Filter\Store\ProductFilterType;

class FindProductController extends Controller
{
    private string $api_key = 'QlnRWTTWw9lv3kjxy1A8byjUmBQedYqb';
    private string $sub_domain = 'https://superposuda.retailcrm.ru';

    public \RetailCrm\Api\Client $client;
    public ProductFilterType $filter;

    /**
     * @throws \RetailCrm\Api\Exception\Client\BuilderException
     */

    public function getProductID(string $name, string $brand): int
    {
        $this->client = SimpleClientFactory::createClient($this->sub_domain, $this->api_key);

        $request = new ProductsRequest();

        $this->filter = new ProductFilterType();

        $request->filter = $this->filter;
        $request->filter->name = $name;
        $request->filter->manufacturer = $brand;

        try {
            $response = $this->client->store->products($request);
        } catch (ApiExceptionInterface | ClientExceptionInterface $exception) {
            echo $exception; // Every ApiExceptionInterface instance should implement __toString() method.
            exit(-1);
        }

        foreach ($response->products as $item){
            foreach($item->offers as $key){
                return $key->id;
            }
        }

    }
}

