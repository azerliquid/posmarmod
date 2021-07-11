<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\BranchStore;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DataTables;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Employe::with('branch', 'user')->get()
        ->sortByDesc('id_employe');
        if ($request->ajax()) {


            return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('role',function($row){
                            return $row->role == NULL ? 'Jabatan Belum Dipilih' : $row->role;  
                        })
                        ->addColumn('branch',function($row){
                            return $row->branch == NULL ? 'Penempatan Belum Dipilih' : $row->branch->branch_name;  
                        })
                        ->addColumn('action', function($row){
                               $btn = '<a  href="" data-toggle="modal" data-target="#modal-edit" class="editModal last" data-id="'.$row->id_employe.'">Edit</a>
                               <a  href="" data-toggle="modal" data-target="#modal-hapus" class="hapusModal last" data-id="'.$row->id_employe.'">Hapus</a>';
                                return $btn;
                        })
                        ->rawColumns(['branch','action'])
                        ->make(true);
        }
        return view('admin.employe.index');

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
        // die($request);
        $user = new User;
        $user->name = $request->name;
        $user->role = $request->role == 'dapur2' ? 'dapur' : $request->role;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $id = $user->id;
        // dd($id);

        $employe = new Employe;
        $employe->name = $request->name;
        $employe->nip = $request->nip;
        $employe->phone = $request->phone;
        $employe->role = $request->role == 'dapur2' ? 'Dapur 2' : $request->role;
        $employe->id_branch = $request->id_branch;
        $employe->id_user = $id;
        $employe->save();

        return redirect()->route('employe.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $employe = Employe::find($id);
        // return response()->json($employe);
        $employe->id_employe = $id;
        $employe->name = $request->name;
        $employe->nip = $request->nip;
        $employe->phone = $request->phone;
        $employe->role = $request->role;
        $employe->id_branch = $request->id_branch;
        $employe->save();

        $user = User::find($employe->id_user);
        $user->name = $employe->name;
        $user->save();

        return redirect()->route('employe.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employe::where('id_employe', $id)->delete();
        return redirect()->route('employe.index');
    }
}
