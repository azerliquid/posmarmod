<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Shopping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $employe = User::where('id', Auth::user()->id)->with('employe')->get();
        // dd($request->data);
        $invoice = new Invoice;
        $invoice->invoice = $request->data['invoice'];
        $invoice->queue = $request->data['queue'];
        $invoice->id_cashier = $request->data['id_cashier'];
        $invoice->id_branch = $employe[0]->employe->id_branch;
        $invoice->cash = $request->data['cash'];
        $invoice->pay = $request->data['pay'];
        $invoice->cash_return = $request->data['cash_return'];
        $invoice->save();
        
        $id_invoice = Invoice::all()->last()->id_invoice;
        $item = $request->data['item'];
        for ($i=0; $i<count($item); $i++) { 
            Shopping::insert([
                'id_invoice' => $id_invoice,
                'id_product' => $item[$i]['id'],
                'price' => $item[$i]['price'],
                'qty' => $item[$i]['qty'],
                'totals' => $item[$i]['qty'] * $item[$i]['price'],
            ]);

        }



        
        // return redirect()->route('cashier.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
