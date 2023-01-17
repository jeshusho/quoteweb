<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quote;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuoteController extends Controller
{
    public function index(){
        return Inertia::render('Quotes/All', [
            'quotes' => Quote::orderBy('id','DESC')->paginate(10),
        ]);
    }

    public function create(){
        return Inertia::render('Quotes/Quote', [
            // 'customers' => Customer::select('*')->selectRaw("CONCAT(code,' - ',document_number,' - ',name)  AS label")
            //                 ->when(request('term'), function ($query, $term) {
            //                     $query->where('code', 'like', "%$term%")
            //                     ->orWhere('name','like',"%$term%")
            //                     ->orWhere('document_number','like',"%$term%");
            //                 })->orderBy('code','ASC')->limit(10)->get(),
            //'quotes' => Quote::orderBy('id','DESC')->paginate(10),
        ]);
    }

    public function searchCustomers($term){
        return Customer::select('*')->selectRaw("CONCAT(code,' - ',name,' - ',document_number)  AS label")
                        ->when(request('term'), function ($query, $term) {
                            $query->where('code', 'like', "%$term%")
                            ->orWhere('name','like',"%$term%")
                            ->orWhere('document_number','like',"%$term%");
                        })->orderBy('code','ASC')->limit(8)->get();
    }

    public function searchServices($term){
        return Service::select('*')->selectRaw("CONCAT(code,' - ',description)  AS label")
                        ->when(request('term'), function ($query, $term) {
                            $query->where('code', 'like', "$term%")
                            ->orWhere('description','like',"$term%");
                        })
                        ->orderBy('code','ASC')->limit(5)->get();
    }

    public function selectedService($id){
        return Service::find($id)->parts;
    }
}
