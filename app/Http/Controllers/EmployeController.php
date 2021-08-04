<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\BranchStore;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Validator;
use Response;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Employe::with('branch', 'user')
        ->where('deleted', 0)->get()
        ->sortBy('name');
        if ($request->ajax()) {


            return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('role',function($row){
                            return $row->role == NULL ? '<a style="color:blue;">Jabatan Belum Dipilih </a>' : $row->role;  
                        })
                        ->addColumn('branch',function($row){
                            return $row->branch == NULL ? '<a style="color:blue;">Penempatan Belum Dipilih </a>' : $row->branch->branch_name;  
                        })
                        ->addColumn('action', function($row){
                               $btn = '<a  href="" data-toggle="modal" data-target="#modal-edit" class="editModal last" data-id="'.$row->id_employe.'">Edit</a>
                               <a  href="" data-toggle="modal" data-target="#modal-hapus" class="hapusModal last" data-id="'.$row->id_employe.'">Hapus</a>';
                                return $btn;
                        })
                        ->rawColumns(['branch','role', 'action'])
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

        $rules = [
            'name' => 'required|max:120|regex:/^[\pL\s\-]+$/u',
            'nip' => 'required|unique:employe|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:13|unique:employe',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
        ];
        
        $messages = [
            'name.required'          => 'Nama wajib diisi.',
            'name.max'               => 'Nama Maximal 120 Karakter.',
            'name.regex'             => 'Nama tidak sesuai format, hanya diisi alphabet.',
            'nip.required'           => 'NIP wajib diisi.',
            'nip.unique'             => 'NIP sudah terdaftar.',
            'nip.regex'              => 'NIP tidak sesuai format, hanya diisi angka.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal diisi dengan 8 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'phone.required'         => 'Nomor Telepon wajib diisi.',
            'phone.unique'           => 'Nomor Telepon sudah terdaftar.',
            'phone.min'              => 'Nomor Telepon minimal 11 Karakter.',
            'phone.max'              => 'Nomor Telepon maksimal 13 Karakter.',
            'phone.regex'            => 'Nomor Telepon terdapat alfabet.',
            'role.required'          => 'Jabatan wajib diisi.',

        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        // $input = $request->all();

        if ($validator->passes()) {
            // die($request);
            $user = new User;
            $user->name = $request->name;
            $user->role = $request->role == 'dapur2' ? 'dapur' : $request->role;
            $user->email = $request->email;
            $user->deleted = 0;
            $user->password = Hash::make($request->password);
            $user->save();

            $id = $user->id;
            // dd($id);

            $employe = new Employe;
            $employe->name = $request->name;
            $employe->nip = $request->nip;
            $employe->phone = $request->phone;
            $employe->role = $request->role == 'dapur2' ? 'Dapur 2' : $request->role;
            // $employe->id_branch = $request->id_branch;
            $employe->id_user = $id;
            $employe->deleted = 0;
            $employe->save();
            
            return Response::json(['success' => 'Data Berhasil Diinputkan !']);

        }
        
        return Response::json(['errors' => $validator->errors()]);

        // return redirect()->route('employe.index');
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
        // return response()->json($request->role);
        
        $user = Employe::where('id_employe',$id)->get('id_user');
        // return response()->json($user);

        $rules = [
            'name' => 'required|max:120|regex:/^[\pL\s\-]+$/u',
            'nip' => 'required|unique:employe,nip,'.$id.',id_employe|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:13|unique:employe,phone,'.$id.',id_employe',
            'email' => 'required|email|max:255|unique:users,email,'.$user[0]->id_user.',id',
            'password' => $request->password == null ? 'sometimes|required_unless:password,null' : 'min:8',
            // 'role' => 'required',
        ];
        
        $messages = [
            'name.required'          => 'Nama wajib diisi.',
            'name.max'               => 'Nama Maximal 120 Karakter.',
            'name.regex'             => 'Nama tidak sesuai format, hanya diisi alphabet.',
            'nip.required'           => 'NIP wajib diisi.',
            'nip.unique'             => 'NIP sudah terdaftar.',
            'nip.regex'              => 'NIP tidak sesuai format, hanya diisi angka.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 8 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'phone.required'         => 'Nomor Telepon wajib diisi.',
            'phone.unique'           => 'Nomor Telepon sudah terdaftar.',
            'phone.min'              => 'Nomor Telepon minimal 11 Karakter.',
            'phone.max'              => 'Nomor Telepon maksimal 13 Karakter.',
            'phone.regex'            => 'Nomor Telepon terdapat alfabet.',
            // 'role.required'          => 'Jabatan wajib diisi.',

        ];
        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->passes()) {
            $employe = Employe::find($id);
            // return response()->json($employe);
            $employe->id_employe = $id;
            $employe->name = $request->name;
            $employe->nip = $request->nip;
            $employe->phone = $request->phone;
            if ($request->role == null) {
                $employe->role =  null;
            }else {
                $employe->role = $request->role == 'dapur2' ? 'Dapur 2' : $request->role;
            }
            $employe->save();
            
            $user = User::find($employe->id_user);
            $user->name = $employe->name;
            if ($request->role == null) {
                $user->role = null;
            }else {
                $user->role = $request->role == 'dapur2' || 'dapur' ? 'dapur' : $request->role;
            }
            $user->email = $request->email;
            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            
            return Response::json(['success' => 'Data Berhasil Diubah !']);

        }

        return Response::json(['errors' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employe = Employe::find($id);
        $employe->deleted = 1;
        $employe->save();

        $user = User::find($employe->id_user);
        $user->deleted = 1;
        $user->save();
        
        return Response::json(['success' => 'Data Berhasil Dihapus !']);
    }
}
