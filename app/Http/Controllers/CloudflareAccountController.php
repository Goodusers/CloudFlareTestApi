<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CloudflareAccount;

class CloudflareAccountController extends include_api_cloudflare
{
    // получаем список доменов
    public function get_domains(){
        $domains = $this->client->request('GET', 'zones');
        $domains = json_decode($domains->getBody()->getContents(), true); 
        return $domains;
    }
  
    public function accounts(){
        $accounts = $this->client->get('accounts');
        $accounts = json_decode($accounts->getBody()->getContents(), true);
        return view('accounts', ['data' => $accounts, 'domains' => $this->get_domains()]);
    }
    public function store_account(Request $request)
    {
        $this->client->put('accounts/'.$request->id_account, [
            'json' => [
                    'name' => $request->name,
                ],
        ]);
        return redirect()->back();
    }
    public function add_domains(Request $request){
        $this->client->post('zones', [
            'json' => [
                    'name' => $request->name,
                ],
        ]);
        return redirect()->back();
    }
}