<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Shopping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;

class QueueInformation extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->with('employe')->latest()->first();
        $id_branch = $user->employe->id_branch;
        
        
        
        return view('kasir.antrian.index',compact('id_branch'));
        // return response()->json($listproduct);
    }
    
    public function getData(Request $request)
    {
        if ($request->ajax()) {
                
            $now = Carbon::now()->toDateString();

            $listproduct = [];
            $user = User::where('id', Auth::user()->id)->with('employe')->latest()->first();
            // $invoice = Invoice::where('status', 0)->where('id_branch',$user->employe->id_branch)->pluck('id_invoice');
            $invoice = Invoice::select('id_invoice', 'queue', 'status', 'created_at')->whereIn('status', [0,2])->where('id_branch',$user->employe->id_branch)->whereDate('created_at', $now)->get();
            // return response()->json($invoice); 
            if (count($invoice) == 0) {
                return response()->json($invoice);
             }else {
                 $time = new DateTime($invoice[0]->created_at);
                 for ($i=0; $i < count($invoice) ; $i++) { 
                     $product = Shopping::select('id_product', 'created_at', 'qty')->where('id_invoice', $invoice[$i]->id_invoice)->where('id_branch', $user->employe->id_branch)->get();
                     
                     // $avg = ($product / 1000) / 60;
                     // dd($product);
                     $compare= [];
                     for ($j=0; $j < count($product) ; $j++) { 
                         $served = Shopping::where('id_product', $product[$j]->id_product)->where('id_branch', $user->employe->id_branch)->where('status', 1)->avg('served');
                         // dd($product[$j]->created_at);
                         // $waiting = strtotime($product[$i]->created_at) + $served;
                         // $avg = ($served / 1000) / 60;
                         array_push($compare, (int)$served * ceil($product[$j]->qty > 1 ? $product[$j]->qty / 2 : 1 ));
                     }
                     // $time = new DateTime($product[0]->created_at);
     
                     $waiting = $time->add(new DateInterval('PT' . round((max($compare)/1000)/60) . 'M'));
                     $dtTemp=array(
                         'invoice' => $invoice[$i],
                         'estimasi'=> round((max($compare) / 1000) /60),
                         'waiting' => $waiting->format('H:i:s'),
                     );
     
                     array_push($listproduct,$dtTemp);
                     // array_push($listproduct,$product);
                 }
                 // $minutes_to_add = 5;
     
                 // $time = new DateTime('2011-11-17 05:05');
                 // $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
     
                 // $stamp = $time->format('Y-m-d H:i');
                 $data = array(
                     'id_branch' => $user->employe->id_branch,
                     'invoice' => $listproduct,
                     // 'coba' => $stamp
                 );
                 return response()->json($data);
             }

        }
        
    }
}
