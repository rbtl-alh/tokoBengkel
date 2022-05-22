<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use App\Models\ProdukImage;
use App\Models\Image;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = array('title' => 'Produk');
        // return view('produk.index', $data);
        $itemuser = $request->user();
        $itemproduk = Produk::orderBy('created_at', 'desc')->paginate(20);
        $itemkategori = Kategori::where('nama_kategori', $request->nama_kategori)->get();
        $data = array('title' => 'Produk',
                    'itemproduk' => $itemproduk,
                    'itemuser' => $itemuser,
                    'itemkategori' => $itemkategori);
        if($itemuser->role == 'admin'){                    
            return view('produk.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
        }else{
            return view('pages.bukanadmin');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $data = array('title' => 'Form Produk Baru');
        // return view('produk.create', $data);
        $itemuser = $request->user();
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $data = array('title' => 'Form Produk Baru',
                    'itemkategori' => $itemkategori,
                    'itemuser' => $itemuser);
        return view('produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'merk'=>'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            // 'foto' => 'required',
        ]);
        $itemuser = $request->user();//ambil data user yang login
        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        // $inputan['status'] = 'publish';
        $itemproduk = Produk::create($inputan);
        return redirect()->route('produk.index')->with('success', 'Data berhasil disimpan');
        // $itemuser = $request->user();//kita panggil data user yang sedang login
        // // $kategori = $request->kategori();//kita panggil data user yang sedang login        
        
        // $produk = new Produk;
        // $produk->id = $request->input('id');
        // $produk->kategori_id = $request->input('kategori_id');
        // $produk->nama = $request->input('nama');
        // $produk->merk = $request->input('merk');
        // $produk->harga = $request->input('harga');
        // $produk->stok = $request->input('stok');
        // $produk->deskripsi = $request->input('deskripsi');
        // $produk->foto = $request->file('foto')->store('fotoProduk');

        // $produk['user_id'] = $itemuser->id;
        // // $produk->kategori_id = $test_id;
        
        
        // $produk->save();

        // return redirect()->route('produk.index')->with('success', 'Data produk berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $itemuser = $request->user();
        $itemproduk = Produk::findOrFail($id);
        $data = array('title' => 'Foto Produk',
                'itemuser' => $itemuser,
                'itemproduk' => $itemproduk);
        return view('produk.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    public function edit(Request $request, $id)
    {
        // $data = array('title' => 'Form Edit Produk');
        // return view('produk.edit', $data);
        $itemuser = $request->user();
        $itemproduk = Produk::findOrFail($id);
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $data = array('title' => 'Form Edit Produk',
                'itemproduk' => $itemproduk,
                'itemuser' => $itemuser,
                'itemkategori' => $itemkategori);
        return view('produk.edit', $data);
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
        $this->validate($request, [
            'nama' => 'required',
            'merk'=>'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            // 'foto' => 'required',
        ]);

        $itemproduk = Produk::findOrFail($id);

        $inputan = $request->all();
        $inputan['id'] = $id;
        $itemproduk->update($inputan);
        return redirect()->route('produk.index')->with('success', 'Data berhasil diupdate');
        // $produk = Produk::findOrFail($id);//cari berdasarkan id = $id, 
        // $validasiid = Produk::where('id', '!=', $id)//yang id-nya tidak sama dengan $id
        //                         ->first();

        // $itemuser = $request->user();//kita panggil data user yang sedang login
        // // $kategori = $request->kategori();//kita panggil data user yang sedang login        
        
        // $produk->kategori_id = $request->input('kategori_id');
        // $produk->nama = $request->input('nama');
        // $produk->merk = $request->input('merk');
        // $produk->harga = $request->input('harga');
        // $produk->stok = $request->input('stok');
        // $produk->deskripsi = $request->input('deskripsi');
        // $produk->foto = $request->file('foto')->store('fotoProduk');

        // $produk['user_id'] = $itemuser->id;
        // // $produk->kategori_id = $test_id;
        
        // $produk->save();

        // return redirect()->route('produk.index')->with('success', 'Data produk berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemproduk = Produk::findOrFail($id);//cari berdasarkan id = $id, 
        // kalo ga ada error page not found 404
        if ($itemproduk->delete()) {
            return back()->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Data gagal dihapus');
        }
    }

    public function uploadimage(Request $request) {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'produk_id' => 'required',
        ]);
        $itemuser = $request->user();
        $itemproduk = Produk::where('user_id', $itemuser->id)
                                ->where('id', $request->produk_id)
                                ->first();
        if ($itemproduk) {
            $fileupload = $request->file('image');
            $folder = 'assets/images';
            $itemgambar = (new ImageController)->upload($fileupload, $itemuser, $folder);
            // simpan ke table produk_images
            $inputan = $request->all();
            $inputan['foto'] = $itemgambar->url;//ambil url file yang barusan diupload
            // simpan ke produk image
            ProdukImage::create($inputan);
            // update banner produk
            $itemproduk->update(['foto' => $itemgambar->url]);
            // end update banner produk
            return back()->with('success', 'Image berhasil diupload');
        } else {
            return back()->with('error', 'Image tidak berhasil diupload');
        }
    }

    public function deleteimage(Request $request, $id) {
        // ambil data produk image by id
        $itemprodukimage = ProdukImage::findOrFail($id);
        // ambil produk by produk_id kalau tidak ada maka error 404
        $itemproduk = Produk::findOrFail($itemprodukimage->produk_id);
        // kita cari dulu database berdasarkan url gambar
        $itemgambar = Image::where('url', $itemprodukimage->foto)->first();
        // hapus imagenya
        if ($itemgambar) {
            Storage::delete($itemgambar->url);
            $itemgambar->delete();
        }
        // baru update hapus produk image
        $itemprodukimage->delete();
        //ambil 1 buah produk image buat diupdate jadi banner produk
        $itemsisaprodukimage = ProdukImage::where('produk_id', $itemproduk->id)->first();
        if ($itemsisaprodukimage) {
            $itemproduk->update(['foto' => $itemsisaprodukimage->foto]);
        } else {
            $itemproduk->update(['foto' => null]);
        }
        //end update jadi banner produk
        return back()->with('success', 'Data berhasil dihapus');
    }
}
