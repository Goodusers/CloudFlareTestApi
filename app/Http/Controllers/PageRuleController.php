<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PageRuleController extends include_api_cloudflare
{
   
    public function index()
    {
        // Получить список правил страницы из Cloudflare
        $response = $this->client->get('/zones/{zone_id}/pagerules');
        $rules = json_decode($response->getBody()->getContents(), true);

        return view('page-rules.index', compact('rules'));
    }

    public function store(Request $request)
    {
        // Добавить правило страницы в Cloudflare
        $this->client->post('/zones/{zone_id}/pagerules', [
            'json' => $request->all(),
        ]);

        return redirect()->route('page-rules.index');
    }

    public function destroy($ruleId)
    {
        // Удалить правило страницы из Cloudflare
        $this->client->delete("/zones/{zone_id}/pagerules/{$ruleId}");

        return redirect()->route('page-rules.index');
    }
}
