<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Validator;
use DataTables;
use Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $category = Category::all();
        $unit = Unit::all();
        // $product = Product::with('categorys', 'units')->get();
        // var_dump($product);
        $data = array('category' => $category,
                        'unit' => $unit,
        );
        // return response()->json([
        //     'product' => $product,

        // ]);
        if ($request->ajax()) {
            $data = Product::with('categorys', 'units')->where('deleted', 0)->get();
            // return response()->json($data);

            return Datatables::of($data)
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
                           $btn = '<a  href="" data-toggle="modal" data-target="#modal-edit" class="editModal last" data-cat="'.$row['id_categorys'].'" data-unit="'.$row['id_units'].'" data-id="'.$row['id_product'].'">Edit</a>
                           <a  href="" data-toggle="modal" data-target="#modal-hapus" class="hapusModal last"  data-id="'.$row['id_product'].'">Hapus</a>';
                            return $btn;
                    })
                    ->rawColumns(['category', 'unit','action'])
                    ->make(true);
        }

        return view('admin.product.index', compact('data'));
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
            'code_products' => 'required|unique:products|max:9',
            'name_products' => 'required|regex:/^[\pL\s\-]+$/u',
            'id_categorys' => 'required',
            'id_units' => 'required',
            'price' => 'required|regex:/^(\d+(,\d{1,2})?)?$/',
        ];

        $messages =  [
            'code_products.required' => 'Kode produk wajib di isi',
            'code_products.unique' => 'Kode produk sudah terdaftar',
            'code_products.max' => 'Kode produk maksimal 9 karakter',
            'name_products.required' => 'Nama produk wajib di isi',
            'name_products.regex' => 'Nama produk hanya di isi alfabet',
            'id_categorys.required' => 'Kategori wajib di isi',
            'id_units.required' => 'Unit wajib di isi',
            'price.required' => 'Harga wajib di isi',
            'price.regex' => 'Format harga salah, contoh : 200000',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $product = new Product;
            $product->code_products = $request->code_products;
            $product->name_products = $request->name_products;
            $product->id_categorys = $request->id_categorys;
            $product->id_units = $request->id_units;
            $product->price = $request->price;
            $product->deleted = 0;
            $product->save();
            return Response::json(['success' => 'Data Berhasil Diinputkan !']);

        }
        return Response::json(['errors' => $validator->errors()]);

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
        $rules = [
            'code_products' => 'required|unique:products,code_products,'.$id.',id_product|max:9',
            'name_products' => 'required|regex:/^[\pL\s\-]+$/u',
            'id_categorys' => 'required',
            'id_units' => 'required',
            'price' => 'required|regex:/^(\d+(,\d{1,2})?)?$/',
        ];

        $messages =  [
            'code_products.required' => 'Kode produk wajib di isi',
            'code_products.unique' => 'Kode produk sudah terdaftar',
            'code_products.max' => 'Kode produk maksimal 9 karakter',
            'name_products.required' => 'Nama produk wajib di isi',
            'name_products.regex' => 'Nama produk hanya di isi alfabet',
            'id_categorys.required' => 'Kategori wajib di isi',
            'id_units.required' => 'Unit wajib di isi',
            'price.required' => 'Harga wajib di isi',
            'price.regex' => 'Format harga salah, contoh : 200000',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            
            // die($request);
            $product = Product::find($id);
            $product->id_product = $id;
            $product->name_products = $request->name_products;
            $product->id_categorys = $request->id_categorys;
            $product->id_units = $request->id_units;
            $product->price = $request->price;
            $product->save();
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
        $product = Product::find($id);
        $product->deleted = 1;
        $product->save();
        
        return Response::json(['success' => 'Data Berhasil Dihapus !']);
    }
}
