<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RetailCrm\Api\Model\Entity\CustomersCorporate\Company;
use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Model\Entity\Orders\Items\Offer;
use RetailCrm\Api\Model\Entity\Orders\Items\OrderProduct;
use RetailCrm\Api\Model\Entity\Orders\Order;
use RetailCrm\Api\Model\Request\Orders\OrdersCreateRequest;
use \RetailCrm\Api\Model\Entity\Customers\Customer;

class SendFormController extends Controller
{
    private string $api_key = 'QlnRWTTWw9lv3kjxy1A8byjUmBQedYqb';
    private string $sub_domain = 'https://superposuda.retailcrm.ru';

    public \RetailCrm\Api\Client $client;
    public OrderProduct $item;
    public Offer $offer;
    public Order $order;
    public OrdersCreateRequest $request;
    public Company $company;
    public Customer $contact;

    /**
     * @throws \RetailCrm\Api\Exception\Api\ApiErrorException
     * @throws ClientExceptionInterface
     * @throws \RetailCrm\Api\Exception\Client\HandlerException
     * @throws \RetailCrm\Api\Exception\Api\MissingCredentialsException
     * @throws \RetailCrm\Api\Exception\Api\AccountDoesNotExistException
     * @throws ApiExceptionInterface
     * @throws \RetailCrm\Api\Exception\Client\HttpClientException
     * @throws \RetailCrm\Api\Exception\Api\MissingParameterException
     * @throws \RetailCrm\Api\Exception\Client\BuilderException
     * @throws \RetailCrm\Api\Exception\Api\ValidationException
     */

    public function __construct()
    {
        $this->request = new OrdersCreateRequest();
        $this->order = new Order();
        $this->offer = new Offer();
        $this->item = new OrderProduct();
        $this->company = new Company();
        $this->contact = new Customer();


        $this->client = SimpleClientFactory::createClient($this->sub_domain, $this->api_key);
        $this->client->api->credentials();
    }

    /**
     * @throws \RetailCrm\Api\Exception\Client\BuilderException
     */

    public function sendForm(Request $req)
    {

        if (!isset($req['submit'])) {
            redirect('/');
        }

        $name = explode(" ", $req['name']);
        $comment = $req['comment'];
        $article = $req['articulate'];
        $brand = $req['brand'];
        $status = "trouble";
        $orderType = "fizik";
        $magazine = "test";
        $orderMethod = "test";
        $number = "25081998";
        $productName = "Маникюрный набор Solingen, 3 пр., белый футляр";
        $findProductID = new FindProductController();

        $productID = $findProductID->getProductID($article, $brand);

        $this->item->offer = $this->offer;
        $this->order->company = $this->company;
        $this->order->contact = $this->contact;

        $this->order->status = $status;
        $this->order->orderType = $orderType;

        $this->order->site = $magazine;
        $this->order->lastName = $name[0];
        $this->order->firstName = $name[1];
        $this->order->patronymic = $name[2];
        $this->order->orderMethod = $orderMethod;
        $this->order->number = $number;

        $this->item->offer->article = $article;
        $this->item->productName = $productName;
        $this->item->id = $productID;
        $this->order->company->brand = $brand;

        $this->order->items = [$this->item];

        $this->order->customerComment = $comment;

        $this->request->order = $this->order;
        $this->request->site = 'test-app';

        try {
            $response = $this->client->orders->create($this->request);
        } catch (ApiExceptionInterface | ClientExceptionInterface $exception) {
            echo $exception; // Every ApiExceptionInterface instance should implement __toString() method.
            exit(-1);
        }

        dd($response);

    }
}
