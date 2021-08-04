<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchStore;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;


class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = BranchStore::select('branchstore*', 'shopping.*', DB::raw('SUM(shopping.qty) As item_sold'))
        //                 ->leftJoin('shopping', 'shopping.id_branch', '=', 'branchstore.id_branch')
        //                 ->where('shopping.created_at', Carbon::today()->toDateString())
        //                 ->get();
        //  return response()->json($data);
        // $data = DB::table('branchstore')
        // ->leftjoin('invoice', 'invoice.id_branch', '=', 'branchstore.id_branch')
        // ->leftjoin('outcome', 'outcome.id_branch', '=', 'branchstore.id_branch')
        // ->get();
        
        // $invoice = 
        // return response()->json($data);
        if ($request->ajax()) {
            $data = DB::table('branchstore')
            ->select("branchstore.*",
                DB::raw("(SELECT SUM(shopping.qty) FROM shopping WHERE shopping.id_branch = branchstore.id_branch
                        GROUP BY shopping.id_branch) as item_sold"),
                DB::raw("(SELECT SUM(invoice.cash) FROM invoice WHERE invoice.id_branch = branchstore.id_branch
                            GROUP BY invoice.id_branch) as income"),
                DB::raw("(SELECT SUM(outcome.outcome) FROM outcome WHERE outcome.id_branch = branchstore.id_branch
                            GROUP BY outcome.id_branch) as outcome"))
            ->get();
        // return response()->json($data);

        return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('cabang',function($row){
                            return $cabang = '<a>'.$row->branch_name.'</a>
                                                <br>
                                                <small>'.$row->address.'</small>';
                        })
                        ->addColumn('income',function($row){
                            return $row->income == null ? "Belum ada Pendapatan" : "Rp. ".$row->income;
                        })
                        ->addColumn('outcome',function($row){
                            return $row->outcome == null ? "Belum ada Pengeluaran" : "Rp. ".$row->outcome;
                        })
                        ->addColumn('profit',function($row){
                            return "Rp. ". ($row->income - $row->outcome);
                        })
                        ->rawColumns(['cabang', 'income', 'outcome', 'profit'])
                        ->make(true);
        }

        
        return view('admin.income.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->starts == null) {
            $data = DB::table('branchstore')
            ->select("branchstore.*",
                DB::raw("(SELECT SUM(shopping.qty) FROM shopping WHERE shopping.id_branch = branchstore.id_branch
                        GROUP BY shopping.id_branch) as item_sold"),
                DB::raw("(SELECT SUM(invoice.cash) FROM invoice WHERE invoice.id_branch = branchstore.id_branch
                            GROUP BY invoice.id_branch) as income"),
                DB::raw("(SELECT SUM(outcome.outcome) FROM outcome WHERE outcome.id_branch = branchstore.id_branch
                            GROUP BY outcome.id_branch) as outcome"))
            ->get();
        }else{
            $startDate = Carbon::createFromFormat('m/d/Y', $request->starts);
            $endDate = Carbon::createFromFormat('m/d/Y', $request->end);
            $data = DB::table('branchstore')
                ->select("branchstore.*",
                    DB::raw("(SELECT SUM(shopping.qty ) FROM shopping WHERE shopping.created_at >= '$startDate' 
                    AND shopping.created_at <= '$endDate' AND shopping.id_branch = branchstore.id_branch
                            GROUP BY shopping.id_branch) as item_sold"),
                    DB::raw("(SELECT SUM(invoice.cash) FROM invoice WHERE invoice.created_at >= '$startDate' 
                    AND invoice.created_at <= '$endDate' AND invoice.id_branch = branchstore.id_branch
                                GROUP BY invoice.id_branch) as income"),
                    DB::raw("(SELECT SUM(outcome.outcome) FROM outcome WHERE outcome.created_at >= '$startDate' 
                    AND outcome.created_at <= '$endDate' AND outcome.id_branch = branchstore.id_branch
                                GROUP BY outcome.id_branch) as outcome"))
                ->get();
        }
                // return response()->json($data);
        return view('admin.income.laporanpendapatanbersih',['data'=>$data, 'start'=>$request->starts, 'end' =>$request->end]);
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
    public function show(Request $request, $type)
    {
        if ($request->ajax()) {
            if ($type == 'today') {
                $data=$this->generateData(Carbon::now(),'=');
                // $now = Carbon::yesterday()->toDateString();

                // $data = DB::table('branchstore')
                // ->select('branchstore.*', DB::raw('SUM(shopping.qty) as item_sold GROUP BY shopping.id_branch'))
                // // $data2 = DB::table('branchstore')
                // ->leftJoin('shopping', 'shopping.id_branch', '=', 'branchstore.id_branch')
                // // ->where('shopping.created_at', '=', $now)
                // // ->groupBy('shopping.id_branch')
                // ->get();
                // return response()->json($data);
            }elseif ($type == 'yesterday') {
                $data=$this->generateData(Carbon::yesterday(),'=');
            }elseif ($type == 'seven_days') {
                $data=$this->generateData(Carbon::now()->subDays(7),'>');
            }elseif ($type == 'last30_day') {
                $data=$this->generateData(Carbon::now()->subDays(30),'>');
            }elseif ($type == 'custom') {
                    
                $startDate = Carbon::createFromFormat('m/d/Y', $_GET['starts']);
                $endDate = Carbon::createFromFormat('m/d/Y', $_GET['end']);

                $data = DB::table('branchstore')
                ->select("branchstore.*",
                    DB::raw("(SELECT SUM(shopping.qty) FROM shopping WHERE shopping.created_at >= '$startDate' 
                    AND shopping.created_at <= '$endDate' AND shopping.id_branch = branchstore.id_branch
                            GROUP BY shopping.id_branch) as item_sold"),
                    DB::raw("(SELECT SUM(invoice.cash) FROM invoice WHERE invoice.created_at >= '$startDate' 
                    AND invoice.created_at <= '$endDate' AND invoice.id_branch = branchstore.id_branch
                                GROUP BY invoice.id_branch) as income"),
                    DB::raw("(SELECT SUM(outcome.outcome) FROM outcome WHERE outcome.created_at >= '$startDate' 
                    AND outcome.created_at <= '$endDate' AND outcome.id_branch = branchstore.id_branch
                                GROUP BY outcome.id_branch) as outcome"))
                ->get();

                
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('cabang',function($row){
                    return $cabang = '<a>'.$row->branch_name.'</a>
                                        <br>
                                        <small>'.$row->address.'</small>';
                })
                ->addColumn('item_sold',function($row){
                    return $row->item_sold == null ? "Belum ada Transaksi" : $row->item_sold;
                })
                ->addColumn('income',function($row){
                    return $row->income == null ? "Belum ada Pendapatan" : "Rp. ".$row->income;
                })
                ->addColumn('outcome',function($row){
                    return $row->outcome == null ? "Belum ada Pengeluaran" : "Rp. ".$row->outcome;
                })
                ->addColumn('profit',function($row){
                    return $row->income - $row->outcome == 0 ? "Belum ada Pendapatan" : "Rp. ".($row->income - $row->outcome);
                })
                ->rawColumns(['cabang', 'income', 'outcome', 'profit'])
                ->make(true);
        }

        return response()->json($data);
    }

    public function generateData(Carbon $type, $operator)
    {
        return DB::table('branchstore')
            ->select("branchstore.*",
                DB::raw("(SELECT SUM(shopping.qty ) FROM shopping WHERE shopping.created_at $operator '$type' 
                AND shopping.id_branch = branchstore.id_branch
                        GROUP BY shopping.id_branch) as item_sold"),
                DB::raw("(SELECT SUM(invoice.cash) FROM invoice WHERE invoice.created_at $operator '$type' 
                AND invoice.id_branch = branchstore.id_branch
                            GROUP BY invoice.id_branch) as income"),
                DB::raw("(SELECT SUM(outcome.outcome) FROM outcome WHERE outcome.created_at $operator '$type' 
                AND outcome.id_branch = branchstore.id_branch
                            GROUP BY outcome.id_branch) as outcome"))
            ->get();

            
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
