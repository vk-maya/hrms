<?php

namespace App\Http\Controllers\Admin;

use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;




class ClientController extends Controller
{
    // -------------ajax route reposce ------------------
    public function cid(Request $request) {
        $rrr = Clients::withTrashed()->where('client_id', 'like', "%$request->id%")->count();
        return response()->json(['cid' => $rrr]);
    }
    public function clientstatus(Request $request){
        $data = Clients::find($request->id);
        if($data->status == 1){
            $data->status= 0;
        }else{
            $data->status= 1;
        }
        $data->save();
        return response()->json(['success'=>"Successfully Changed"]);
    }
    public function index() {
        $client = Clients::all();

        return view('admin.Client.client', compact('client'));
    }
    public function clist(){
        $clist = Clients::all();

        return view('admin.Client.client', compact('clist'));
    }
    public function create($id = ""){
        if ($id > 0) {
            $client = Clients::find($id);
            $count = Countries::all();
            return view('admin.Client.add-client', compact('count', 'client'));
        } else {
            $count = Countries::all();
            $id = Clients::latest()->first();
            if($id ==!null){

                $client_id = $id->client_id;
            }else{
                $client_id= 1000;
            }
            return view('admin.Client.add-client', compact('count','client_id'),);
        }

    }
    public function store(Request $request){
        // dd($request->toArray());


        if ($request->id == !null) {

            $client = Clients::find($request->id);
        } else {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'client_id' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string'],
                'company' => ['required', 'string',],
                'website' => ['required', 'string',],
                'address' => ['required', 'string',],
                'country' => ['required', 'string'],
                'state' => ['required', 'string'],
                'city' => ['required', 'string'],
                'status' => ['required'],
                'image' => ['required', 'mimes:png,jpg,jpeg,csv', 'max:2048'],
                 ];
            $request->validate($rules);
            $client = new Clients();
        }
        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->client_id = $request->client_id;
        $client->phone = $request->phone;
        $client->company = $request->company;
        $client->website = $request->website;
        $client->address = $request->address;
        $client->country_id = $request->country;
        $client->state_id = $request->state;
        $client->city_id = $request->city;
        $client->status = ($request->status == 1) ? 1 : 0;
        if ($request->hasFile('image') == 1) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "client" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
            $file = $request->file('image')->storeAs('public/client', $filename);
            $client->image = $filename;
        }
        $client->save();
        return redirect()->route('admin.client');
    }
    public function delete($id){
        $delete = Clients::find($id);
        if ($delete->image != '') {
            storage::delete('public/uploads/' . $delete->image);
        }
        $delete->delete();
        return response()->json(['msg' => 'yes']);
    }
}
