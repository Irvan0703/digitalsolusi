<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ProductController extends Controller
{
     /**
     * index
     *
     * @return View
     */

    public function index(): View
    {
        $products = Product::latest()->paginate();

        return view('products.index', compact('products'));
    }

     /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

     /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'merek'     => 'required|min:1',
            'jumlah'     => 'min:0',
            'harga'     => 'min:0'
        ]);


        //create post
        Product::create([
            'merek'     => $request->merek,
            'jenis'   => $request->jenis,
            'jumlah'     => $request->jumlah,
            'harga'     => $request->harga,
            'keterangan' => $request->keterangan,
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

      /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get post by ID
        $products = Product::findOrFail($id);

        //render view with post
        return view('products.show', compact('products'));
    }

     /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get post by ID
        $products = Product::findOrFail($id);

        //render view with post
        return view('products.edit', compact('products'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'merek'     => 'required|min:1',
            'jumlah'     => 'min:0',
            'harga'     => 'min:0'
        ]);

        //get post by ID
        $products = Product::findOrFail($id);


            //update post with new image
            $products->update([
            'merek'     => $request->merek,
            'jenis'   => $request->jenis,
            'jumlah'     => $request->jumlah,
            'harga'     => $request->harga,
            'keterangan' => $request->keterangan,
            ]);



        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

     /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $product = Product::findOrFail($id);


        //delete post
        $product->delete();

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $product = Product::query()
        ->where('merek', 'like', "%".$search."%")
        ->paginate();

        return view('products.index', compact('products'));
    }
}
