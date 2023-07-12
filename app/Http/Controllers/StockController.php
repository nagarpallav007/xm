<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function showForm()
    {
        $response = Http::get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');
    
        $symbols = collect(json_decode($response->body(), true))
            ->pluck('Symbol')
            ->toArray();
    
        return view('forms.form', compact('symbols'));
    }
    
    
    

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'symbol' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date|before_or_equal:' . now()->format('Y-m-d'),
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:' . now()->format('Y-m-d'),
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $validatedData = $validator->validated();
    
        $symbol = $validatedData['symbol'];
        $startDate = $validatedData['start_date'];
        $endDate = $validatedData['end_date'];
    
        $quotes = $this->getHistoricalQuotes($symbol, $startDate, $endDate);
    
        // Prepare data for the view
        $data = [
            'symbol' => $symbol,
            'quotes' => $quotes,
        ];
    
        // Send email
        //$this->sendEmail($symbol, $startDate, $endDate, $validatedData['email']);
    
        if ($request->expectsJson()) {
            return response()->json($data);
        }
    
        return view('forms.result', $data);
    }
    

    private function getHistoricalQuotes($symbol, $startDate, $endDate)
    {
        $apiKey = env('RAPIDAPI_KEY');
        $apiHost = env('RAPIDAPI_HOST');

        $url = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol={$symbol}&region=US";
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => $apiKey,
            'X-RapidAPI-Host' => $apiHost,
        ])->get($url);

        $data = $response->json();

        return $data['prices'];
    }

    private function sendEmail($symbol, $startDate, $endDate, $email)
    {
        $companyName = $this->getCompanyName($symbol);

        $subject = $companyName;
        $body = "From {$startDate} to {$endDate}";

        Mail::raw($body, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    private function getCompanyName($symbol)
    {
        $response = Http::get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');

        $companies = collect($response->json())->keyBy('Symbol');
        $company = $companies->get($symbol);

        return $company['Company Name'] ?? '';
    }
}
