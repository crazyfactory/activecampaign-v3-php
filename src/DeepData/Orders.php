<?php

namespace CrazyFactory\ActiveCampaignClient\DeepData;

use CrazyFactory\ActiveCampaignClient\Resource;

/**
 * Class Orders
 * @package CrazyFactory\ActiveCampaignClient\DeepData
 * @see https://developers.activecampaign.com/reference/orders
 */
class Orders extends Resource
{
    /**
     * Create an order
     * @see https://developers.activecampaign.com/reference/create-order
     *
     * @param array $order
     * @return string
     */
    public function create(array $order)
    {
        $req = $this->client
            ->getClient()
            ->post('/api/3/ecomOrders', [
                'json' => [
                    'ecomOrder' => $order,
                ],
            ]);

        return $req->getBody()->getContents();
    }

    /**
     * List all orders
     * @see https://developers.activecampaign.com/reference/list-all-orders
     *
     * @param array $query_params
     * @param int   $limit
     * @param int   $offset
     * @return string
     */
    public function listAll(array $query_params = [], int $limit = 20, int $offset = 0)
    {
        $query_params = array_merge($query_params, [
            'limit'  => $limit,
            'offset' => $offset,
        ]);

        $req = $this->client
            ->getClient()
            ->get('/api/3/ecomOrders', [
                'query' => $query_params,
            ]);

        return $req->getBody()->getContents();
    }

    /**
     * Update an order
     * @see https://developers.activecampaign.com/reference/update-order
     *
     * @param int   $id
     * @param array $order
     * @return string
     */
    public function update(int $id, array $order)
    {
        $req = $this->client
            ->getClient()
            ->put('/api/3/ecomOrders/' . $id, [
                'json' => [
                    'ecomOrder' => $order,
                ],
            ]);

        return $req->getBody()->getContents();
    }

    /**
     * Get an order
     * @see https://developers.activecampaign.com/reference/get-order
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        $req = $this->client
            ->getClient()
            ->get('/api/3/ecomOrders/' . $id);

        $response = $req->getBody()->getContents();
        $data     = json_decode($response, true);
        $order    = $data['ecomOrder'];
        $ecom_id  = $order['id'];

        $req = $this->client
            ->getClient()
            ->get('/api/3/ecomOrders/' . $ecom_id . '/orderProducts');

        $product = json_decode($req->getBody()->getContents(), true);

        $req = $this->client
            ->getClient()
            ->get('/api/3/ecomOrders/' . $ecom_id . '/orderDiscounts');

        $discount = json_decode($req->getBody()->getContents(), true);

        return [
            'externalcheckoutid'  => $order['externalcheckoutid'],
            'email'               => $order['email'],
            'orderProducts'       => $product['ecomOrderProducts'],
            'orderDiscounts'      => $discount['ecomOrderDiscounts'],
            'orderUrl'            => $order['orderUrl'],
            'totalPrice'          => $order['totalPrice'],
            'shippingAmount'      => $order['shippingAmount'],
            'discountAmount'      => $order['discountAmount'],
            'currency'            => $order['currency'],
            'connectionid'        => $order['connectionid'],
            'customerid'          => $order['customerid'],
            'externalCreatedDate' => date('Y-m-d\TH:i:s.000\Z', strtotime($order['externalCreatedDate'])),
            'abandoned_date'      => date('Y-m-d\TH:i:s.000\Z', time()),
        ];
    }

    /**
     * Delete an order
     * @see https://developers.activecampaign.com/reference/delete-order
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $orderId): bool
    {
        $req = $this->client
            ->getClient()
            ->delete('/api/3/ecomOrders/' . $orderId);

        return 200 === $req->getStatusCode();
    }
}
