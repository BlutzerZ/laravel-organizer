<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Proker;
use App\Services\PostingManagementServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostingController extends Controller
{
    var $postingManagementServices;
    public function __construct(PostingManagementServices $postingManagementServices){
        $this->postingManagementServices = $postingManagementServices;
    }
    public function index($id) : View
    {
        $proker = Proker::all();
        $Proker  = $proker->find($id);
        
        if($Proker->status != trim('berjalan')){
            dd($Proker);
        }

        $postingans = DB::table('post')->where('proker_id', $id)->get();

        $data['option'] = '';
        $data['proker'] = $Proker;
        $data['postingan'] = $postingans;
        return view('post.postingview', $data);
    }

    public function addView($id) : View
    {
        $proker = Proker::all();
        $Proker  = $proker->find($id);
        if($Proker->status != trim('berjalan')){
            dd($Proker);
        }
        $data['option'] = 'tambah';
        $data['proker'] = $Proker;
        
        return view('post.postingview', $data);
    }

    public function editView(Request $request){

        $proker = Proker::all();
        $Proker  = $proker->find($request->proker_id);
        if($Proker->status != trim('berjalan')){
            dd($Proker);
        }

        $posting = Post::all();
        $postingan = $posting->find($request->posting_id);
        $data = [
            'postingan' => $postingan,
            'proker' => $Proker,
            'option' => 'edit'
        ];

        return view('post.postingview', $data);
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'Deskripsi' => ['required', 'max:255']
        ]);
        
        try{
            $data = $this->postingManagementServices->store($request);

            return redirect('/dashboard');
        }catch (\Exception $e) {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "error".$e->getMessage();
        }
    }

    public function update(Request $request) : RedirectResponse
    {
        $request->validate([
            'deskripsi'  => ['required', 'string', 'max:255'],
        ]);
        $myroute = '/postingan/view/'.$request->proker_id;
        try{
            $check = $this->postingManagementServices->update($request);
            return redirect($myroute)->with($request->proker_id);
        }catch(\Exception $e){
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "error".$e->getMessage();
        }
    }

    public function delete(Request $request) : RedirectResponse
    {
        $myroute = '/postingan/view/'.$request->proker_id;
        try{
            $check = $this->postingManagementServices->delete($request);
            return redirect($myroute)->with($request->proker_id);
        }catch(\Exception $e){
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "error".$e->getMessage();
        }
    }
}
