<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use GuzzleHttp\Client;
use App\Models\CloudflareAccount;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DomainController extends include_api_cloudflare
{
    public function index(){ // Главная страница - вход
        return view('index');
    }
    public function signin_form(Request $request){ // обработка пост запроса на вход
        $validate = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ],[
            'email.required' => 'Поле не может быть пустым',
            'password.required' => 'Поле не может быть пустым',
        ]);
        
        if(Auth::attempt($validate)){
                return redirect(route('page'));
        }
        return redirect(route('index'))->withErrors(['password'=>'Не удалось авторизироваться']);
    }
    public function user_id(){ // данные о пользователях
        $user = $this->client->request('GET', 'user');
        $result = json_decode($user->getBody()->getContents(), true);
        return $result;
    } 
    public function memberships(){ // id аккаунта
         
        $response_accounts = $this->client->request('GET', 'memberships');
        $accounts = json_decode($response_accounts->getBody()->getContents(), true);
        
        foreach ($accounts as $value) {
            if (isset($value[0]['account'])){
                $ret_array[] = $value[0]['account'];
                $result = $ret_array[0]['id'];
                return $result ;
            }
          
        }
    }
    public function get_member(){ // получаем участников
                
        $list = $this->client->request('GET', 'accounts/'. $this->memberships().'/members');
        $list = json_decode($list->getBody()->getContents(), true);
        return $list['result'][0]['roles'][0]['id'];
    }
    public function page()
    {
        $list = $this->client->request('GET', 'accounts/'. $this->memberships().'/members');
        $list = json_decode($list->getBody()->getContents(), true);

        $list = $this->client->request('GET', 'accounts/'. $this->memberships().'/members');
        $list = json_decode($list->getBody()->getContents(), true);
        
        return view('page', ['user' => $this->user_id(), 'member' => $this->memberships(), 'list' => $list]);
    }
    
    public function add_member(Request $request){
        $validated = $request->validate([
            'account_id' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $policy = $this->client->request('GET', 'accounts/'. $this->memberships().'/members');
        $policy = json_decode($policy->getBody()->getContents(), true);

        $userData = [
            'account_id' => $this->memberships(),
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        $this->client->post('accounts/'. $this->memberships().'/members', [
                'json' => [
                    // 'account_id' => $userData['account_id'],
                    'email' => $userData['email'],
                    'roles' => [
                        $userData['role']
                    ],
                    'status' => 'pending',
                    
                ],
            ]);
            return redirect()->back();
    }
    public function delete_member(Request $request){
        // dd($request->delete);
        $this->client->delete('accounts/'. $this->memberships().'/members'.'/'.$request->delete);
        return redirect()->back();
    }

    public function store(Request $request)
    {
        // Добавить домен в Cloudflare
        $this->client->post('/zones', [
            'json' => [
                'name' => $request->name,
                'jump_start' => true,
            ],
        ]);

        // Сохранить домен в базе данных
        Domain::create($request->only('name'));

        return redirect()->route('domains.index');
    }

    public function destroy(Domain $domain)
    {
        // Удалить домен из Cloudflare
        $this->client->delete("/zones/{$domain->id}");

        // Удалить домен из базы данных
        $domain->delete();

        return redirect()->route('domains.index');
    }

    public function updateSSL(Request $request, Domain $domain)
    {
        // Обновить настройки SSL для домена
        $this->client->patch("/zones/{$domain->id}/settings/ssl", [
            'json' => [
                'value' => $request->value,
            ],
        ]);

        return redirect()->route('domains.index');
    }
}
