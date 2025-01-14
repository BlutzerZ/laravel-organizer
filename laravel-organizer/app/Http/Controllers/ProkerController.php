<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProkerRequest;
use App\Models\Proker;
use App\Services\ProkerManagementServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProkerController extends Controller
{
    var $prokerManagementServices;
    public function __construct(ProkerManagementServices $prokermanagementservices){
        $this->prokerManagementServices = $prokermanagementservices;
    }

    public function index() : View
    {
        $proker = Proker::all();

        $data['option'] = '';
        $data['proker'] = $proker;
        return view('proker.prokerview', $data);
    }

    public function addView() : View
    {
        $data['option'] = 'tambah';
        return view('proker.prokerview', $data);
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'Proker_name' => ['required', 'string', 'max:255'],
        ]);
        try{
            $data = $this->prokerManagementServices->store($request);

            return redirect('/dashboard');
        }catch (\Exception $e) {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "error".$e->getMessage();
        }
        
    }

    public function update(Request $request)    :   RedirectResponse
    {
        $request->validate([
            'Proker_name' => ['required', 'string', 'max:255'],
        ]);

        try{
            $data = $this->prokerManagementServices->update($request);

            return redirect('/dashboard');
        }catch (\Exception $e) {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "error".$e->getMessage();
        }
    }

    public function editView($id) : View
    {
        $proker = Proker::all();
        $data['profile'] = $proker->find($id);
        $data['option'] = 'edit';

        return view('proker.prokerview', $data);
    }

    public function delete($id) : RedirectResponse
    {
        try{
            $data = $this->prokerManagementServices->delete($id);
        }catch (\Exception $e) {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "error".$e->getMessage();
        }
        return redirect('prokerview');
    }
}
