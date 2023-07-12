<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function testStockFormValidation()
    {
        $response = $this->post('/stock/submit', []);
        $response->assertSessionHasErrors(['symbol', 'start_date', 'end_date', 'email']);
    }
    
    public function testStockFormSubmission()
    {
        // Disable email sending during testing
        Mail::fake();
    
        $symbol = 'AAPL';
        $startDate = '2023-01-01';
        $endDate = '2023-01-31';
        $email = 'test@example.com';
    
        $this->mockHttpCalls();
    
        $response = $this->post('/stock/submit', [
            'symbol' => $symbol,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'email' => $email,
        ]);
    
        $response->assertStatus(200); // Updated assertion
        $response->assertSessionDoesntHaveErrors();
    }
    

    private function mockHttpCalls()
    {
        Http::fake([
            'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json' => Http::response([
                [
                    'Symbol' => 'AAPL',
                    'Company Name' => 'Apple Inc.',
                ],
            ]),
            'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=AAPL&region=US' => Http::response([
                'prices' => [
                    [
                        'date' => '2023-01-01',
                        'open' => 150.25,
                        'high' => 155.50,
                        'low' => 148.75,
                        'close' => 152.50,
                        'volume' => 1000000,
                    ],
                    [
                        'date' => '2023-01-02',
                        'open' => 152.75,
                        'high' => 158.00,
                        'low' => 151.50,
                        'close' => 157.25,
                        'volume' => 1200000,
                    ],
                ],
            ]),
        ]);
    }
}
