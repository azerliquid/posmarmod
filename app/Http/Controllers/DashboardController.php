<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shopping;
use App\Models\Outcome;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        


        // $most_transactions = Invoice::with('branch:id_branch,branch_name')
        // ->where('status', 1)
        // ->selectRaw(' id_branch, SUM(cash) as income')
        // ->groupBy('id_branch')
        // // ->pluck( 'total_item_sold', 'id_product');
        // ->get();


        return view('admin.dashboard.index');
        // return response()->json($totals_item_sold);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now();
        $sevenday = Carbon::now()->subDays(7)->startOfDay();
        $income = Invoice::select(
            DB::raw("SUM(status) as buyer"),
            DB::raw("SUM(cash) as income"),)
            ->where('status', 1)
            ->whereDate('created_at','=',$now)
            ->get();
        $item_sold_daily = Shopping::select(
            DB::raw("SUM(qty) as item_sold"))
            ->where('status', 1)
            ->whereDate('created_at','=',$now)
            ->get();
        $item_sold_weekly = Shopping::select(
            DB::raw("SUM(qty) as item_sold"))
            ->where('status', 1)
            ->whereDate('created_at','>=',$sevenday)
            ->get();
        $outcome = Outcome::select(
            DB::raw("SUM(outcome) as outcome"))
            ->whereDate('created_at','=',$now)
            ->get();

        $product = Shopping::where('status', 1)
        ->selectRaw('SUM(qty) as total_item_sold')
        ->whereDate('created_at','>=',$sevenday)
        ->groupBy('id_product')
        ->get();

        $sold_product = Shopping::with('products:id_product,name_products,code_products')
        ->where('status', 1)
        ->whereDate('created_at','>=',$sevenday)
        ->selectRaw(' id_product, SUM(qty) as item_sold')
        // ->select('SUM(qty) as most_item_sold')
        ->groupBy('id_product')
        ->orderByDesc('item_sold')
        // ->pluck( 'total_item_sold', 'id_product');
        ->get();

        // $totals_item_sold = Shopping::sum('qty')->where('status', 1);

        // $most_item_sold = array(
        //     'sold_product' => $sold_product,
        //     'totals_item_sold' => $totals_item_sold 
        // );
        
        // $weekly_income = Invoice::selectRaw('created_at,SUM(cash) as weekly_income')
        // ->whereDate('created_at','>=', $sevenday)
        // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
        // ->get();

        $weekly_income =  DB::table('invoice')
            ->where('invoice.created_at', '>=', $sevenday)
            ->groupBy(DB::raw('DATE(invoice.created_at)'))
            ->select(
                DB::raw('DATE(invoice.created_at) as date'),
                DB::raw('SUM(invoice.cash) as total')
            )->get();

        $weekly_outcome =  DB::table('outcome')
            ->where('outcome.created_at', '>=', $sevenday)
            ->groupBy(DB::raw('DATE(outcome.created_at)'))
            ->select(
                DB::raw('DATE(outcome.created_at) as date'),
                DB::raw('SUM(outcome.outcome) as totaloutcome')
            )->get();
        
        

        $data = array(
            'income' => intval($income[0]->income),
            'buyer' => $income[0]->buyer,
            'outcome' => intval($outcome[0]->outcome),
            'item_sold_daily' => $item_sold_daily[0]->item_sold,
            'item_sold_weekly' => $item_sold_weekly[0]->item_sold,
            'profit' => intval($income[0]->income) - $outcome[0]->outcome,
            'favorite' => $sold_product,
            'weekly_income' => $weekly_income,
            'weekly_outcome' => $weekly_outcome,
        );
        return response()->json($data);
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
