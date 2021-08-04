<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Branchstore;
use DataTables;
use PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Event\SendListOrder;

class OutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $branch = Employe::where('id_user', Auth::user()->id)->latest()->first();
        if ($request->ajax()) {
            // dd('oke');
            if (Auth::user()->role == 'kasir') {
                
                $data = Outcome::where('id_branch', $branch->id_branch)->get()
                        ->sortByDesc('id_outcome');
                
                
                // return response()->json($data);

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('datebaru',function($row){
                            $dt = strtotime($row->date);

                            $date = date('d M Y',$dt);
                            return $date;
                        })
                        ->addColumn('prices',function($row){
                            return $row['price'] = "Rp. ".$row['price'];
                        })
                        ->addColumn('outcomes',function($row){
                            return $row['outcome'] = "Rp. ".$row['outcome'];
                        })
                        ->addColumn('action', function($row){
                               $btn = '<a  href="" data-toggle="modal" class="detailModal last" data-id="'.$row->id_outcome.'">Detail</a>';
                                return $btn;
                        })
                        ->rawColumns(['branch', 'prices', 'outcomes', 'datebaru','action'])
                        ->make(true);
            }else {
                $data = DB::table('Outcome')
                    ->leftJoin('branchstore', 'outcome.id_branch', '=', 'branchstore.id_branch')
                    ->orderBy('outcome.created_at', 'DESC')
                    // ->whereDate('outcome.created_at',$operator, $type)
                    ->select('outcome.*', 'branchstore.branch_name')
                    ->get();
                // return response()->json($data);

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('datebaru',function($row){
                            $dt = strtotime($row->date);

                            $date = date('d M Y',$dt);
                            return $date;
                        })
                        ->addColumn('prices',function($row){
                            return $row->price = "Rp. ".$row->price;
                        })
                        ->addColumn('outcomes',function($row){
                            return $row->outcome = "Rp. ".$row->outcome;
                        })
                        ->addColumn('branch',function($row){
                            return $row->branch_name;
                        })
                        ->addColumn('action', function($row){
                               $btn = '<a  href="" data-toggle="modal" class="detailModal last" data-id="'.$row->id_outcome.'">Detail</a>';
                                return $btn;
                        })
                        ->rawColumns(['branch', 'prices', 'outcomes','datebaru','action'])
                        ->make(true);
            }
                
        }
        
        if (Auth::user()->role == 'kasir') {
            // $branch = Employe::where('id_user', Auth::user()->id)->latest()->first();
            return view('kasir.outcome.index', compact('branch'));
        }else {
            $branch2 = Branchstore::all()->sortBy('branch_name');
            return view('admin.outcome.index', compact('branch2'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return response()->json($request->starts);
        if ($request->starts == null) {
            $data = Outcome::with('branch')
            ->get()
            ->sortByDesc('id_outcome');
        }else{
            $startDate = Carbon::createFromFormat('m/d/Y', $request->starts);
            $endDate = Carbon::createFromFormat('m/d/Y', $request->end);
            $data = Outcome::with('branch')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            // ->sortByDesc('id_outcome')
            ->get();
        }
                // return response()->json($data);
        return view('admin.outcome.laporanpengeluaran',['data'=>$data, 'start'=>$request->starts, 'end' =>$request->end]);
        
        // return response()->json($data);
        // return view('admin.outcome.laporanpengeluaran', compact());
        // return view('',['data'=>$data]);
    	// return $pdf->stream('laporanpengeluaran.pdf', array("Attachment" => false));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $outcome = new Outcome;
        $outcome->name = $request->name;
        $outcome->id_branch = $request->id_branch;
        $outcome->cashier_name = $request->cashier_name;
        $outcome->price = $request->price;
        $outcome->qty = $request->qty;
        $outcome->outcome = $request->outcome;
        $outcome->save();

        return redirect()->route('outcome.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $type)
    {        
        if ($request->ajax()) {
            if (Auth::user()->role == 'kasir') {
                $branch = Employe::where('id_user', Auth::user()->id)->latest()->first();
                if ($type == 'today') {
                    $data=$this->generateKasir(Carbon::now(),'=', $branch->id_branch);
                }elseif ($type == 'yesterday') {
                    $data=$this->generateKasir(Carbon::yesterday(),'=', $branch->id_branch);
                }elseif ($type == 'seven_days') {
                    $data=$this->generateKasir(Carbon::now()->subDays(7),'>', $branch->id_branch);
                }elseif ($type == 'last30_day') {
                    $data=$this->generateKasir(Carbon::now()->subDays(30),'>', $branch->id_branch);
                }elseif ($type == 'custom') {
                    
                    $startDate = Carbon::createFromFormat('m/d/Y', $_GET['starts']);
                    $endDate = Carbon::createFromFormat('m/d/Y', $_GET['end']);

                    $data = DB::table('Outcome')
                    ->leftJoin('branchstore', 'outcome.id_branch', '=', 'branchstore.id_branch')
                    ->orderBy('outcome.created_at', 'DESC')
                    ->whereDate('outcome.created_at', '>=', $startDate)
                    ->whereDate('outcome.created_at', '<=', $endDate)
                    ->select('outcome.*', 'branchstore.branch_name')
                    ->get();
                }
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('datebaru',function($row){
                            $dt = strtotime($row->date);

                            $date = date('d M Y',$dt);
                            return $date;
                        })
                        ->addColumn('prices',function($row){
                            return $row->price = "Rp. ".$row->price;
                        })
                        ->addColumn('outcomes',function($row){
                            return $row->outcome = "Rp. ".$row->outcome;
                        })
                        ->addColumn('action', function($row){
                               $btn = '<a  href="" data-toggle="modal" class="detailModal last" data-id="'.$row->id_outcome.'">Detail</a>';
                                return $btn;
                        })
                        ->rawColumns(['branch', 'prices', 'outcomes', 'datebaru','action'])
                        ->make(true);
            }else {
                if ($type == 'today') {
                    $data=$this->generateAdmin(Carbon::now(),'=');
                }elseif ($type == 'yesterday') {
                    $data=$this->generateAdmin(Carbon::yesterday(),'=');
                }elseif ($type == 'seven_days') {
                    $data=$this->generateAdmin(Carbon::now()->subDays(7),'>');
                }elseif ($type == 'last30_day') {
                    $data=$this->generateAdmin(Carbon::now()->subDays(30),'>');
                }elseif ($type == 'custom') {
                    
                    $startDate = Carbon::createFromFormat('m/d/Y', $_GET['starts']);
                    $endDate = Carbon::createFromFormat('m/d/Y', $_GET['end']);

                    $data = DB::table('Outcome')
                    ->leftJoin('branchstore', 'outcome.id_branch', '=', 'branchstore.id_branch')
                    ->orderBy('outcome.created_at', 'DESC')
                    ->whereDate('outcome.created_at', '>=', $startDate)
                    ->whereDate('outcome.created_at', '<=', $endDate)
                    ->select('outcome.*', 'branchstore.branch_name')
                    ->get();
                }else{
                    $data = DB::table('Outcome')
                    ->leftJoin('branchstore', 'outcome.id_branch', '=', 'branchstore.id_branch')
                    ->orderBy('outcome.created_at', 'DESC')
                    ->where('outcome.id_branch', $type)
                    ->select('outcome.*', 'branchstore.branch_name')
                    ->get();
                }
                return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('datebaru',function($row){
                                $dt = strtotime($row->date);
    
                                $date = date('d M Y',$dt);
                                return $date;
                            })
                            ->addColumn('prices',function($row){
                                return $row->price = "Rp. ".$row->price;
                            })
                            ->addColumn('outcomes',function($row){
                                return $row->outcome = "Rp. ".$row->outcome;
                            })
                            ->addColumn('branch',function($row){
                                return $row->branch_name;
                            })
                            ->addColumn('action', function($row){
                                   $btn = '<a  href="" data-toggle="modal" class="detailModal last" data-id="">Detail</a>';
                                    return $btn;
                            })
                            ->rawColumns(['branch', 'prices', 'outcomes', 'datebaru','action'])
                            ->make(true);
            }
            
        }
    }

    public function generateAdmin(Carbon $type,$operator)
    {
        return DB::table('Outcome')
                    ->leftJoin('branchstore', 'outcome.id_branch', '=', 'branchstore.id_branch')
                    ->orderBy('outcome.created_at', 'DESC')
                    ->whereDate('outcome.created_at',$operator, $type)
                    ->select('outcome.*', 'branchstore.branch_name')
                    ->get();  
    }

    public function generateKasir(Carbon $type,$operator, $id_branch)
    {
        return DB::table('Outcome')
                    ->leftJoin('branchstore', 'outcome.id_branch', '=', 'branchstore.id_branch')
                    ->orderBy('outcome.created_at', 'DESC')
                    ->whereDate('outcome.created_at',$operator, $type)
                    ->where('outcome.id_branch', '=', $id_branch)
                    ->select('outcome.*', 'branchstore.branch_name')
                    ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function edit(Outcome $outcome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outcome $outcome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outcome $outcome)
    {
        //
    }

    
}
