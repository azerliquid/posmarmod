<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Shopping;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListOrderController extends Controller
{
    public function index()
    {
        $now = Carbon::now()->toDateString();
        // $data = Invoice::with('shopping.product')->get();

        
        $user = User::where('id', Auth::user()->id)->with('employe')->latest()->first();

        // $invoice = Invoice::select('id_invoice', 'queue', 'id_branch')->with('shopping')->whereDate('created_at', $now)->where('id_branch', 11)->get();
        $data = DB::table('invoice')
        ->leftJoin('shopping', 'invoice.id_invoice', '=', 'shopping.id_invoice')
        ->leftJoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->select('invoice.id_invoice', 'invoice.queue', 'shopping.id_shopping','shopping.qty','shopping.status','products.id_product', 'products.name_products')

        // ->where('invoice.id_invoice', $id)
        ->whereDate('invoice.created_at', $now)
        ->where('invoice.id_branch', $user->employe->id_branch)
        ->where('invoice.status', 0)
        
        // ->leftJoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->get();
        // $data = array('invoice' => $invoice,
        //                 'item' => $item);
        // return response()->json( $user->employe->id_branch);
        // dd((array)$data);
        // $cnt = array_filter((array)$data,function($element) {
        //     $c=0;
        //     for ($i=0; $i < 14; $i++) { 
        //         if($element[$i]->id_invoice == 53){
        //             $c++;
        //         }
        //     }
        //     return $c;
        //   });
        //   echo $cnt;
        //   dd($user->employe);
        return view('dapur.listorder.index', compact('data', 'user'));
    }

    public function update(Request $request)
    {
        // return response()->json($request);
        // dd($request);
        $shopping = Shopping::find($request->id);
        $shopping->served = $request->time;
        $shopping->status = 1;

        $shopping->save();

        $check = Shopping::where('status', 0)->where('id_invoice', $request->id_invoice)->get();
        return response()->json($check);
    }
}
