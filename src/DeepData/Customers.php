<?php

namespace CrazyFactory\ActiveCampaignClient\DeepData;

use CrazyFactory\ActiveCampaignClient\Resource;

/**
 * Class Customers
 * @package CrazyFactory\ActiveCampaignClient\DeepData
 * @see https://developers.activecampaign.com/reference/customers
 */
class Customers extends Resource
{
    /**
     * Create a customer
     * @see https://developers.activecampaign.com/reference/create-customer
     *
     * @param array $customer
     * @return string
     */
    public function create(array $customer): string
    {
        $req = $this->client
            ->getClient()
            ->post('/api/3/ecomCustomers', [
                'json' => [
                    'ecomCustomer' => $customer,
                ],
            ]);

        return $req->getBody()->getContents();
    }

    /**
     * Delete a customer
     * @see https://developers.activecampaign.com/reference/delete-customer
     *
     * @param int $id
     * @return string
     */
    public function delete(int $id): bool
    {
        $req = $this->client
            ->getClient()
            ->delete('/api/3/ecomCustomers/' . $id);

        return 200 === $req->getStatusCode();
    }

    /**
     * List all customers
     * @see https://developers.activecampaign.com/reference/list-all-customers
     *
     * @param array $query_params
     * @param int   $limit
     * @param int   $offset
     * @return string
     */
    public function listAll(array $query_params = [], int $limit = 20, int $offset = 0): string
    {
        $query_params = array_merge($query_params, [
            'limit'  => $limit,
            'offset' => $offset,
        ]);

        $req = $this->client
            ->getClient()
            ->get('/api/3/ecomCustomers', [
                'query' => $query_params,
            ]);

        return $req->getBody()->getContents();
    }
}
