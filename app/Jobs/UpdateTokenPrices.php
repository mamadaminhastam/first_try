<?php

namespace App\Jobs;

use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdateTokenPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $tokens = Token::all();
        // نگاشت نمادهای پروژه به جفت‌ارزهای Binance
        $binanceMap = [
            'BTC' => 'BTCUSDT',
            'ETH' => 'ETHUSDT',
            'BNB' => 'BNBUSDT',
            'SOL' => 'SOLUSDT',
            'ADA' => 'ADAUSDT',
            'XRP' => 'XRPUSDT',
            'DOGE' => 'DOGEUSDT',
            'DOT' => 'DOTUSDT',
            'AVAX' => 'AVAXUSDT',
            'LINK' => 'LINKUSDT',
            'MATIC' => 'MATICUSDT',
            'UNI' => 'UNIUSDT',
            'SHIB' => 'SHIBUSDT',
            'LTC' => 'LTCUSDT',
            'TRX' => 'TRXUSDT',
            'XLM' => 'XLMUSDT',
            'ATOM' => 'ATOMUSDT',
            'FIL' => 'FILUSDT',
            // توکن‌های استیبل‌کوین تقریباً ثابت می‌مانند
            'USDT' => 'USDCUSDT', // برای قیمت نزدیک به ۱
            'USDC' => 'USDCUSDT',
        ];

        foreach ($tokens as $token) {
            $symbol = strtoupper($token->symbol);
            if (!isset($binanceMap[$symbol])) {
                continue; // اگر نماد در نقشه نبود، رد شود
            }

            try {
                $response = Http::timeout(5)
                    ->get("https://api.binance.com/api/v3/ticker/price", [
                        'symbol' => $binanceMap[$symbol]
                    ]);

                if ($response->successful()) {
                    $price = (float) $response->json('price');
                    // اگر استیبل‌کوین بود، قیمت را روی ۱ نگه داریم
                    if (in_array($symbol, ['USDT', 'USDC', 'DAI'])) {
                        $price = 1.00;
                    }
                    $token->update(['price_usd' => $price]);
                }
            } catch (\Exception $e) {
                // خطا را نادیده بگیرید
            }
        }
    }
}
