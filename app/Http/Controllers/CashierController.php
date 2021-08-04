<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashier;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\User;
use App\Models\BranchStore;
use App\Models\Shopping;
use App\Models\Outcome;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use App\Events\SendListOrder;
use App\Events\SendInformation;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $invoice = Invoice::select('id_invoice', 'queue')->where('status', 0)->where('id_branch',50)->get();

        // $product = Shopping::where('id_product', 227)->where('id_branch', 50)->where('status', 1)->avg('served');
        // $avg = ($product / 1000) / 60;


        // $product = Shopping::where('id_invoice', 475)->where('id_branch', 45)->pluck('id_product', 'created_at');
        // $product2 = Shopping::select('id_product', 'created_at')->where('id_invoice', 475)->where('id_branch', 45)->get();
        
        // dd(gettype($product2[0]->created_at ));
        // return response()->json($product);
        $now = Carbon::now()->toDateString();
        $user = User::with('employe')->where('id', Auth::user()->id)->latest()->first();
        $queue = Invoice::where('id_cashier', Auth::user()->id)->whereDate('created_at', '=', $now)->pluck('queue')->last();
        $branch = BranchStore::where('id_cashier', $user->employe->id_employe)->latest()->first();
        $income = Invoice::whereDate('created_at', '=', $now)->where('id_branch', '=', $branch->id_branch)->sum('cash');
        $outcome = Outcome::whereDate('created_at', '=', $now)->where('id_branch', '=', $branch->id_branch)->sum('outcome');
        $itemsold = Shopping::whereDate('created_at', '=', $now)->where('id_branch', '=', $branch->id_branch)->sum('qty');

        $data = array('buyer' => ($queue == null) ? 0 : $queue,
                        'item_sold' => ($itemsold == null) ? 0 : $itemsold,
                        'queue' => ($queue == null) ? 1 : $queue + 1,
                        'invoice' => 'INV' . date('ymd') . $branch->id_branch . ($queue + 1),
                        'id_branch' => $branch,
                        'branch_store' => $branch->branch_name,
                        'user' => $user,
                        'incometotals' => substr($income, 0, strlen($income)-3) . 'K',
                        'outcometotals' => substr($outcome, 0, strlen($outcome)-3) . 'K',
        );
        if ($request->ajax()) {
            // return response()->json($data);
            $product = Product::with('categorys', 'units')
            ->where('deleted', 0)
            ->orderBy('name_products', 'ASC')
            ->get();

            return Datatables::of($product)
                    ->addIndexColumn()
                    ->addColumn('category',function($row){
                        return $row['categorys']->categorys;
                    })
                    ->addColumn('unit',function($row){
                        return $row['units']->units;
                    })
                    ->addColumn('price',function($row){
                        return $row['price'] = "Rp. ".$row['price'];
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a  id="add'.$row['id_product'].'" style="font-size:11px;" data-toggle="tooltip" data-placement="right" title="Tambah" class="btn btn-sm btn-primary atc" data-id="'.$row['id_product'].'"><i class="fa fa-plus" style="color:white;"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['category', 'unit','action'])
                    ->make(true);
        }
        // return response()->json([
        //     'data' => $data,

        // ]);

        return view('kasir.cashier.index', compact('data'));
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
        $invoice->status = 0;
        $invoice->save();
        
        $id_invoice = $invoice->id_invoice;
        $id_branch = $invoice->id_branch;
        $item = $request->data['item'];
        for ($i=0; $i<count($item); $i++) { 
            Shopping::insert([
                'id_branch' => $id_branch,
                'id_invoice' => $id_invoice,
                'id_product' => $item[$i]['id'],
                'price' => $item[$i]['price'],
                'qty' => $item[$i]['qty'],
                'totals' => $item[$i]['qty'] * $item[$i]['price'],
                'status' => 0,
            ]);

        }

        $broadcast_item = DB::table('shopping')
        ->leftjoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->where('id_invoice', $id_invoice)
        ->select('shopping.*', 'products.name_products')
        ->get();

        // return response()->json($broadcast_item);
        event(new SendListOrder($invoice, $broadcast_item, $invoice->id_branch));
        event(new SendInformation($invoice, $invoice->id_branch));

        $nota = DB::table('invoice')
        ->leftJoin('shopping', 'invoice.id_invoice', '=', 'shopping.id_invoice')
        ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
        ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
        ->leftJoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->select('invoice.*', 'employe.name','branchstore.branch_name', 'shopping.price', 'shopping.qty', 'shopping.totals', 'products.name_products')
        ->where('invoice.id_invoice', $invoice->id_invoice) 
        // ->leftJoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->get();

        return response()->json(['success' => 'Transaksi Berhasil Ditambah !', 'nota' => $nota]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function show(Cashier $cashier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashier $cashier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashier $cashier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashier $cashier)
    {
        //
    }

    public function hit(Request $request)
    {
        event(new \App\Events\SendListOrder($request->message));
        return 1;
    }
}
