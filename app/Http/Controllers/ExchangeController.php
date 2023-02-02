<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function createToday()
    {
        $yesterday_exchange = null;
        if(Exchange::count()>0) $yesterday_exchange = Exchange::orderBy('id','DESC')->first();
        $today = Carbon::today('America/Lima')->isoFormat('YYYY-MM-DD');
        if(is_null($yesterday_exchange)) $exchange = Exchange::create(['date' => $today, 'currency' => 'USD']);
        else{
            $exchange = Exchange::create([
                'source' => $yesterday_exchange->source,
                'date' => $today,
                'currency' => $yesterday_exchange->currency,
                'real_buy' => $yesterday_exchange->real_buy,
                'real_sell' => $yesterday_exchange->real_sell,
                'sell' => $yesterday_exchange->sell,
                'exchange_rate' => $yesterday_exchange->exchange_rate,
            ]);
        }
        return $exchange;
    }

    public function updateToday()
    {
        $today_exchange = Exchange::orderBy('id','DESC')->first();
        $today = $today_exchange->date;
        $url = 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha=' . $today;
        $exchange = Http::retry(3, 6000)->acceptJson()->get($url);
        $data=json_decode($exchange);
        $today_exchange->source = 'apis.net.pe';
        $today_exchange->real_buy = $data->compra;
        $today_exchange->real_sell = $data->venta;
        $today_exchange->sell = $data->venta;
        $today_exchange->exchange_rate = 1/$data->venta;
        $today_exchange->save();
        return $today_exchange;
    }
}
