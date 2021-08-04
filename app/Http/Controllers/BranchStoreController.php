<?php

namespace App\Http\Controllers;

use App\Models\BranchStore;
use Illuminate\Http\Request;
use App\Models\Employe;
use Illuminate\Support\Facades\DB;
use Validator;
use Response;

class BranchStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = BranchStore::with('cashier', 'chef', 'chef2')->orderBy('branch_name')->get();
        $employe = Employe::with('branch:id_branch,branch_name')->where('deleted', 0)->get();
        $data = array('branch' => $branch,
                        'employe' => $employe, );
        // return response()->json([
        //     'data' => $data,
        // ]);
        return view('admin.branchstore.index', compact('data'));
        // if ($request->ajax()) {
        //     $data = Donatur::latest()->get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($row){
        //             $btn = '<a  href="" data-toggle="modal" data-target="#modal-edit" class="editModal last" >Edit</a>';
        //             // $btn = '<button type="button" onclick="location.href =\''.route('admin.donatur.show', $row->id_donatur).'\'" class="detail btn btn-info btn-sm mr-1 detailBtn">Detail</button>';
        //             // $btn .= '<button type="button" data-id="/admin/donatur/'.$row->id_donatur.'/edit" class="edit btn btn-warning btn-sm mr-1 editBtn">Edit</button>';
        //             // $btn .= '<button type="submit" data-id="/admin/donatur/'.$row->id_donatur.'" class="btn btn-danger btn-sm deleteBtn">Delete</button>';
        //             return $btn;
        //         })  
        //         ->rawColumns(['action'])
        //         ->make(true);
        //     }
        //     return view('admin.branchstore.index');
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

        $rules = [
            'branch_name' => 'required|unique:branchstore',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:13|unique:branchstore',
            'address' => 'required',
        ];
        
        $messages = [
            'branch_name.required'          => 'Nama wajib diisi.',
            'branch_name.unique'            => 'Nama sudah terdaftar.',
            'address.required'       => 'Alamat wajib diisi.',
            'phone.required'         => 'Nomor Telepon wajib diisi.',
            'phone.unique'           => 'Nomor Telepon sudah terdaftar.',
            'phone.min'              => 'Nomor Telepon minimal 11 Karakter.',
            'phone.max'              => 'Nomor Telepon maksimal 13 Karakter.',
            'phone.regex'            => 'Nomor Telepon terdapat alfabet.',

        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        // $input = $request->all();

        // dd($request);
        if ($validator->passes()) {
            $branchstore = new BranchStore;
            $branchstore->branch_name = $request->branch_name;
            $branchstore->phone = $request->phone;
            $branchstore->address = $request->address;
            $cashier = $branchstore->id_cashier = $request->cashier == null ? null : $request->cashier;
            $chef = $branchstore->id_chef =  $request->chef == null ? null : $request->chef;
            $chef2 = $branchstore->id_chef2 = $request->chef2 == null ? null : $request->chef2;
            $branchstore->save();
    
            $listemploye = [$cashier, $chef, $chef2];
            $id_branch = $branchstore->id_branch;
            $role = ['Kasir', 'Dapur', 'Dapur2'];
            
            // dd($listemploye);
            for ($i=0; $i < count($listemploye); $i++) {
                if ($listemploye[$i] != null) {
                    $employe = Employe::find($listemploye[$i]);
                    $employe->id_branch = $id_branch;
                    $employe->role = $role[$i];
                    $employe->save();
                }
            }

            
            return Response::json(['success' => 'Data Berhasil Diinputkan !']);

        }
        
        return Response::json(['errors' => $validator->errors()]);

        // return redirect()->route('employe.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchStore  $branchStore
     * @return \Illuminate\Http\Response
     */
    public function show(BranchStore $branchStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchStore  $branchStore
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchStore $branchStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchStore  $branchStore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $rules = [
            'branch_name' => 'required|unique:branchstore,branch_name,'.$id.',id_branch',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:13|unique:branchstore,phone,'.$id.',id_branch',
            'address' => 'required',
            // 'chef2' => 'unique:branchstore,id_cashier,'.$id.',id_branch,id_chef,'.$request->chef.',id_chef2,'.$request->chef2.',',
        ];
        
        $messages = [
            'branch_name.required'          => 'Nama wajib diisi.',
            'branch_name.unique'            => 'Nama sudah terdaftar.',
            'address.required'       => 'Alamat wajib diisi.',
            'phone.required'         => 'Nomor Telepon wajib diisi.',
            'phone.unique'           => 'Nomor Telepon sudah terdaftar.',
            'phone.min'              => 'Nomor Telepon minimal 11 Karakter.',
            'phone.max'              => 'Nomor Telepon maksimal 13 Karakter.',
            'phone.regex'            => 'Nomor Telepon terdapat alfabet.',
            // 'chef2.unique'            => 'Karyawan sudah ditempatkan, pilih karyawan yang kosong.',

        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            
            $branchstore = BranchStore::find($id);
            $branchstore->id_branch = $id;
            $branchstore->branch_name = $request->branch_name;
            $branchstore->phone = $request->phone;
            $branchstore->address = $request->address;
            $branchstore->id_cashier = $request->cashier == 'default' ? null : $request->cashier;
            $branchstore->id_chef = $request->chef == 'default' ? null : $request->chef;
            $branchstore->id_chef2 = $request->chef2 == 'default' ? null : $request->chef2;
            $branchstore->save();
    
            
            $listemploye = [$branchstore->id_cashier, $branchstore->id_chef, $branchstore->id_chef2];
            $listid = [$request->id_cashier, $request->id_chef, $request->id_chef2];
            $id_branch = $branchstore->id_branch;
            $role = ['Kasir', 'Dapur', 'Dapur 2'];
            
            // dd($listemploye);
            for ($i=0; $i < count($listemploye); $i++) {
                if ($listid[$i] != null ) {
                    $employe = Employe::find($listid[$i]);
                    $employe->id_branch = $listemploye[$i] == null ? null : $id_branch;
                    $employe->role = $listemploye[$i] == null ? null : $role[$i];
                    $employe->save();
                }elseif ($listemploye[$i] != null ) {
                    $employe = Employe::find($listemploye[$i]);
                    $employe->id_branch = $id_branch;
                    $employe->role = $role[$i];
                    $employe->save();
                }
            }  
            return Response::json(['success' => 'Data Berhasil Diinputkan !']);
            // return Response::json(['id' => $listid, 'emp' => $listemploye]);
        }
        
        return Response::json(['errors' => $validator->errors()]);

        // return redirect()->route('employe.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchStore  $branchStore
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BranchStore::where('id_branch', $id)->delete();
        return redirect()->route('branchstore.index');
    }
}
