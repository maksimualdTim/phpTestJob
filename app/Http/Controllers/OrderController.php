<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|max:255',
            'comment' => 'required',
            'article_number' => 'required',
            'brend' => 'required',
        ]);

        $comment = $request->input('comment');
        $fullname = explode(' ', $request->input('full_name'));
        $product_article_number = $request->input('article_number');
        $manufacturer = $request->input('brend');

        $firstName = $fullname[1];
        $lastName = $fullname[0];
        $patronymic = $fullname[2];

        $client = new Client(['base_uri' => 'https://superposuda.retailcrm.ru/api/v5/']);

        $response = $client->request('GET', 'store/products', [
            'query' => [
                'apiKey' => env('API_KEY'),
                'filter[name]' => $product_article_number,
                'filter[manufacturer]' => $manufacturer,
            ]
        ])->getBody()->getContents();

        $good = json_decode($response);

        $storeOrderResult = $client->request('POST', 'orders/create', [
            'json' => [
                'apiKey' => env('API_KEY'),
                'order[status]' => 'trouble',
                'order[lastName]' => $lastName,
                'order[firstName]' => $firstName,
                'order[patronymic]' => $patronymic,
                'order[customerComment]' => $comment,
                'order[orderType]' => 'fizik', 
                'order[orderMethod]' => 'test',
                'order[number]' => '25092001',
                'order[customer][site]' => 'test',
                'order[items][][offer][id]' => $good->products[0]->offers[0]->id,
            ]
        ])->getBody()->getContents();

        return response($storeOrderResult);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
