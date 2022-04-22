<?php

namespace App\Http\Controllers\Admin;

use App\Models\Countrie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientModel;
use Illuminate\Auth\Events\Validated;



class ClientController extends Controller
{
    public function index()
    {
        $client = ClientModel::all();

        return view('admin.Client.client', compact('client'));
    }
    public function clist()
    {
        $clist = ClientModel::all();

        return view('admin.Client.client', compact('clist'));
    }
    public function create()
    {
        $count = Countrie::all();
        return view('admin.Client.add-client', compact('count'),);
    }
    public function store(Request $request)
    {
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
            // 'state' => ['required', 'string'],
            // 'city' => ['required', 'string'],
            'status' => ['required'],
            'image' => ['required', 'mimes:png,jpg,jpeg,csv', 'max:2048'],
        ];
        $request->validate($rules);
        $client = new ClientModel();
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
        $client->image = '';
        if ($request->hasFile('image') == 1) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "client" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
            $file = $request->file('image')->storeAs('public/client', $filename);
            $client->image = $filename;
        }
        // dd($client->toArray());
        $client->save();
        return redirect()->route('admin.client');
    }
}
