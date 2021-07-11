<?php

namespace App\Http\Controllers;

use App\Models\HistoryTransactions;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;

class HistoryTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $user = User::where('id', Auth::user()->id)->with('employe')->latest()->first();
            $data = Invoice::where('id_branch', $user->employe->id_branch)
            ->orderBy('id_invoice', 'DESC')
            ->get();

            
            if (Auth::user()->role == 'kasir') {
        
                // return response()->json([
                //     'data' => $data,
                // ]);
                
                // return view('kasir.historytransactions.index', compact('data'));
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('datebaru',function($row){
                            $dt = strtotime($row['created_at']);

                            $date = date('d M Y',$dt);
                            return $date;
                        })
                        ->addColumn('cashs',function($row){
                            return $row['cash'] = "Rp. ".$row['cash'];
                        })
                        ->addColumn('pays',function($row){
                            return $row['pay'] = "Rp. ".$row['pay'];
                        })
                        ->addColumn('cash_returns',function($row){
                            return $row['cash_return'] = "Rp. ".$row['cash_return'];
                        })
                        ->addColumn('status',function($row){
                            $status = $row['status'] == 0 ? 'Belum' : 'Selesai';

                            return $status;
                        })
                        ->addColumn('action', function($row){
                            if ($status = $row->status == 1) {
                                $btn = '<a  href="" data-toggle="modal" class="detailModal last" onclick="getData('.$row->id_invoice.')">Detail</a>';
                            }else {
                                $btn = '<a  href="" data-toggle="modal" class="detailModal last" onclick="getData('.$row->id_invoice.')">Detail</a>
                                        <a id="btn'.$row->id_invoice.'" href="" data-toggle="modal" class="selesai last" onclick="setSelesai('.$row->id_invoice.')">Selesai</a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['datebaru','cashs', 'pays', 'cash_returns', 'action'])
                        ->make(true);
                
            }else {
                // $data = Invoice::with('cashier', 'branch')->get();
                $data = DB::table('invoice')
                ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
                ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
                ->orderBy('invoice.created_at', 'DESC')
                ->select('invoice.*', 'branchstore.branch_name', 'employe.name')
                // ->where('invoice.id_branch', 11)
                ->get();
        
                // return response()->json([
                //     'data' => $data,
                // ]);
                // dd('admin');
                // return view('admin.reporttransactions.index', compact('data'));
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('datebaru',function($row){
                            $dt = strtotime($row->created_at);

                            $date = date('d M Y',$dt);
                            return $date;
                        })
                        ->addColumn('cashs',function($row){
                            return $row->cash = "Rp. ".$row->cash;
                        })
                        ->addColumn('pays',function($row){
                            return $row->pay = "Rp. ".$row->pay;
                        })
                        ->addColumn('cash_returns',function($row){
                            return $row->cash_return = "Rp. ".$row->cash_return;
                        })
                        ->addColumn('status',function($row){
                            $status = $row->status == 0 ? 'Belum' : 'Selesai';

                            return $status;
                        })
                        ->addColumn('action', function($row){
                               $btn = '<a  href="" data-toggle="modal" class="detailModal last" onclick="getData('.$row->id_invoice.')">Detail</a>';
                                return $btn;
                        })
                        ->rawColumns(['cashs','pays','cash_returns', 'status', 'datebaru','action'])
                        ->make(true);
                
            }
        }
        
        if (Auth::user()->role == 'kasir') {
            return view('kasir.historytransactions.index');
        }else {
            return view('admin.reporttransactions.index');
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        
        // return response()->json($request->from);
        
        
        if ($request->starts == null) {
            $data = DB::table('invoice')
                    ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
                    ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
                    ->orderBy('invoice.created_at', 'DESC')
                    // ->where('invoice.created_at', '=' )
                    ->select('invoice.*', 'branchstore.branch_name', 'employe.name')
                    ->get();
        }else{
            $startDate = Carbon::createFromFormat('m/d/Y', $request->starts);
            $endDate = Carbon::createFromFormat('m/d/Y', $request->end);
            $data = DB::table('invoice')
                    ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
                    ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
                    ->orderBy('invoice.created_at', 'DESC')
                    ->whereDate('invoice.created_at', '>=', $startDate)
                    ->whereDate('invoice.created_at', '<=', $endDate)
                    // ->where('invoice.created_at', '=' )
                    ->select('invoice.*', 'branchstore.branch_name', 'employe.name')
                    ->get();
        }
                // return response()->json($data);
        return view('admin.reporttransactions.laporantransaksi',['data'=>$data, 'start'=>$request->starts, 'end' =>$request->end]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HistoryTransactions  $historyTransactions
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $type)
    {
        if ($request->ajax()) {
            if (Auth::user()->role == 'kasir') {
                $user = User::where('id', Auth::user()->id)->with('employe')->latest()->first();
                if ($type == 'today') {
                    $data=$this->generateKasir(Carbon::now(),'=', $user->employe->id_branch);
                }elseif ($type == 'yesterday') {
                    $data=$this->generateKasir(Carbon::yesterday(),'=', $user->employe->id_branch);
                }elseif ($type == 'seven_days') {
                    $data=$this->generateKasir(Carbon::now()->subDays(7),'>', $user->employe->id_branch);
                }elseif ($type == 'last30_day') {
                    $data=$this->generateKasir(Carbon::now()->subDays(30),'>', $user->employe->id_branch);
                }elseif($type=='custom'){
                    $startDate = Carbon::createFromFormat('m/d/Y', $_GET['starts']);
                    $endDate = Carbon::createFromFormat('m/d/Y', $_GET['end']);

                    $data = Invoice::where('id_branch', $user->employe->id_branch)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=',$endDate)
                    // ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('id_invoice', 'DESC')
                    ->get();
                }
                return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('datebaru',function($row){
                                $dt = strtotime($row->created_at);

                                $date = date('d M Y',$dt);
                                return $date;
                            })
                            ->addColumn('cashs',function($row){
                                return $row->cash = "Rp. ".$row->cash;
                            })
                            ->addColumn('pays',function($row){
                                return $row->pay = "Rp. ".$row->pay;
                            })
                            ->addColumn('cash_returns',function($row){
                                return $row->cash_return = "Rp. ".$row->cash_return;
                            })
                            ->addColumn('status',function($row){
                                $status = $row->status == 0 ? 'Belum' : 'Selesai';

                                return $status;
                            })
                            ->addColumn('action', function($row){
                                if ($status = $row->status == 1) {
                                    $btn = '<a  href="" data-toggle="modal" class="detailModal last" onclick="getData('.$row->id_invoice.')">Detail</a>';
                                }else {
                                    $btn = '<a  href="" data-toggle="modal" class="detailModal last" onclick="getData('.$row->id_invoice.')">Detail</a>
                                            <a id="btn'.$row->id_invoice.'" href="" data-toggle="modal" class="selesai last" onclick="setSelesai('.$row->id_invoice.')">Selesai</a>';
                                }
                                return $btn;
                            })
                            ->rawColumns(['datebaru','cashs', 'pays', 'cash_returns', 'action'])
                            ->make(true);
            } else {
                if ($type == 'today') {
                    $data=$this->generateAdmin(Carbon::now(),'=');
                }elseif ($type == 'yesterday') {
                    $data=$this->generateAdmin(Carbon::yesterday(),'=');
                }elseif ($type == 'seven_days') {
                    $data=$this->generateAdmin(Carbon::now()->subDays(7),'>');
                }elseif ($type == 'last30_day') {
                    $data=$this->generateAdmin(Carbon::now()->subDays(30),'>');
                }elseif($type=='custom'){
                    $startDate = Carbon::createFromFormat('m/d/Y', $_GET['starts']);
                    $endDate = Carbon::createFromFormat('m/d/Y', $_GET['end']);

                    // $data = Invoice::whereDate('created_at', '>=', $startDate)
                    // ->whereDate('created_at', '<=',$endDate)
                    // // ->whereBetween('created_at', [$startDate
                    // ->orderBy('id_invoice', 'DESC')
                    // ->get();

                    $data = DB::table('invoice')
                    ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
                    ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
                    ->whereDate('invoice.created_at', '>=', $startDate)
                    ->whereDate('invoice.created_at', '<=', $endDate)
                    // ->orderBy('invoice.created_at', 'DESC')
                    ->select('invoice.*', 'branchstore.branch_name', 'employe.name')
                    ->get();  
                    
                }
                return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('datebaru',function($row){
                                $dt = strtotime($row->created_at);

                                $date = date('d M Y',$dt);
                                return $date;
                            })
                            ->addColumn('cashs',function($row){
                                return $row->cash = "Rp. ".$row->cash;
                            })
                            ->addColumn('pays',function($row){
                                return $row->pay = "Rp. ".$row->pay;
                            })
                            ->addColumn('cash_returns',function($row){
                                return $row->cash_return = "Rp. ".$row->cash_return;
                            })
                            ->addColumn('status',function($row){
                                $status = $row->status == 0 ? 'Belum' : 'Selesai';
    
                                return $status;
                            })
                            ->addColumn('action', function($row){
                                $btn = '<a  href="" data-toggle="modal" class="detailModal last" data-id="'.$row->id_invoice.'">Detail</a>';
                                return $btn;
                            })
                            ->rawColumns(['cashs', 'pays', 'cash_returns', 'status', 'datebaru','action'])
                            ->make(true);
            }
        } 
        
    }


    public function generateAdmin(Carbon $type,$operator)
    {
        return DB::table('invoice')
                    ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
                    ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
                    ->orderBy('invoice.created_at', 'DESC')
                    ->whereDate('invoice.created_at',$operator, $type)
                    ->select('invoice.*', 'branchstore.branch_name', 'employe.name')
                    ->get();  
    }

    public function generateKasir(Carbon $type,$operator, $id)
    {
        return DB::table('invoice')
            ->where('id_branch', $id)
            ->whereDate('created_at',$operator, $type)
            ->orderBy('id_invoice', 'DESC')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HistoryTransactions  $historyTransactions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('invoice')
        ->leftJoin('shopping', 'invoice.id_invoice', '=', 'shopping.id_invoice')
        ->leftJoin('employe', 'invoice.id_cashier', '=', 'employe.id_user')
        ->leftJoin('branchstore', 'invoice.id_branch', '=', 'branchstore.id_branch')
        ->leftJoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->select('invoice.*', 'employe.name','branchstore.branch_name', 'shopping.price', 'shopping.qty', 'shopping.totals', 'products.name_products')
        ->where('invoice.id_invoice', $id)
        // ->leftJoin('products', 'shopping.id_product', '=', 'products.id_product')
        ->get();

        return response()->json(
             $data,
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HistoryTransactions  $historyTransactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = 1;
        $invoice->save();
        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HistoryTransactions  $historyTransactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistoryTransactions $historyTransactions)
    {
        //
    }
}
