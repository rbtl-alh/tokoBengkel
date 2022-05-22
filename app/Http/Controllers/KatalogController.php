<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = array('title' => 'Kategori Produk');
        // return view('katalog.index', $data);
        // kita ambil data kategori per halaman 20 data dan (paginate(20))
        // kita urutkan yang terakhir diiput yang paling atas (orderBy)
        $itemuser = $request->user();
        $itemkategori = Kategori::orderBy('created_at', 'desc')->paginate(20);
        $data = array('title' => 'Kategori Produk',
                    'itemkategori' => $itemkategori,
                    'itemuser' => $itemuser);
        if($itemuser->role == 'admin'){                    
            return view('katalog.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
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
        $itemuser = $request->user();
        $data = array('title' => 'Form Kategori',
                    'itemuser' => $itemuser);
        return view('katalog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'kode_kategori' => 'required|unique:kategoris',
        //     'nama_kategori'=>'required',
        //     'jumlah' => 'required',
        //     'foto' => 'required',
        // ]);
        // $itemuser = $request->user();//kita panggil data user yang sedang login

        // $inputan = new Kategori;
        // $inputan->id = $request->input('id');
        // $inputan->nama_kategori = $request->input('nama_kategori');
        // $inputan->kode_kategori = $request->input('kode_kategori');
        // $inputan->jumlah = $request->input('jumlah');
        // $inputan->foto = $request->file('foto')->store('products');

        // // $inputan = $request->all();//kita masukkan semua variabel data yang diinput ke variabel $inputan
        // $inputan['user_id'] = $itemuser->id;
        // // $itemkategori = Kategori::create($inputan);
        // $inputan->save();

        // return redirect()->route('katalog.index')->with('success', 'Data kategori berhasil disimpan');

        $this->validate($request, [
            'kode_kategori' => 'required|unique:kategoris',
            'nama_kategori'=>'required',
            // 'slug_kategori' => 'required',
            // 'deskripsi_kategori' => 'required',
        ]);
        $itemuser = $request->user();//kita panggil data user yang sedang login
        // $inputan = $request->file('foto')->store('products');
        $inputan = $request->all();//kita masukkan semua variabel data yang diinput ke variabel $inputan
        $inputan['user_id'] = $itemuser->id;
        //slug kita gunakan nanti pas buka produk per kategori
        $inputan['status'] = 'publish';//status kita set langsung publish saja
        $itemkategori = Kategori::create($inputan);
        return redirect()->route('katalog.index')->with('success', 'Data kategori berhasil disimpan');
    
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
    // public function edit($id)
    public function edit(Request $request, $id)
    {
        // $data = array('title' => 'Form Edit Kategori');
        // return view('katalog.edit', $data);
        $itemuser = $request->user();
        $itemkategori = Kategori::findOrFail($id);//cari berdasarkan id = $id, 
        // kalo ga ada error page not found 404
        $data = array('title' => 'Form Edit Kategori',
                    'itemkategori' => $itemkategori,
                    'itemuser' => $itemuser);
        return view('katalog.edit', $data);
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
            // 'kode_kategori' => 'required',
            'nama_kategori'=>'required',
            'jumlah' => 'required',
            // 'foto' => 'required',
        ]);
        $itemkategori = Kategori::findOrFail($id);//cari berdasarkan id = $id, 
        $validasislug = Kategori::where('id', '!=', $id)//yang id-nya tidak sama dengan $id
                                ->first();
        
        $itemuser = $request->user();
        // $itemkategori->id = $request->input('id');
        $itemkategori->nama_kategori = $request->input('nama_kategori');
        $itemkategori->kode_kategori = $request->input('kode_kategori');
        $itemkategori->jumlah = $request->input('jumlah');
        // $itemkategori->foto = $request->file('foto')->store('products');

        $itemkategori['user_id'] = $itemuser->id;
        // $inputan = $request->all();
        $itemkategori->save();
        // $itemkategori->update($itemkategori);
        return redirect()->route('katalog.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('katalog.index')->with('success', 'Data berhasil dihapus');        
    }

    public function uploadimage(Request $request) {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required',
        ]);
        $itemuser = $request->user();
        $itemkategori = Kategori::where('user_id', $itemuser->id)
                                ->where('id', $request->kategori_id)
                                ->first();
        if ($itemkategori) {
            $fileupload = $request->file('image');
            $folder = 'assets/images';
            $itemgambar = (new ImageController)->upload($fileupload, $itemuser, $folder);
            $inputan['foto'] = $itemgambar->url;//ambil url file yang barusan diupload
            $itemkategori->update($inputan);
            return back()->with('success', 'Image berhasil diupload');
        } else {
            return back()->with('error', 'Kategori tidak ditemukan');
        }
    }

    public function deleteimage(Request $request, $id) {
        $itemuser = $request->user();
        $itemkategori = Kategori::where('user_id', $itemuser->id)
                                ->where('id', $id)
                                ->first();
        if ($itemkategori) {
            // kita cari dulu database berdasarkan url gambar
            $itemgambar = Image::where('url', $itemkategori->foto)->first();
            // hapus imagenya
            if ($itemgambar) {
                Storage::delete($itemgambar->url);
                $itemgambar->delete();
            }
            // baru update foto kategori
            $itemkategori->update(['url' => null]);
            $itemkategori->update(['foto' => null]);
            return back()->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }
}
