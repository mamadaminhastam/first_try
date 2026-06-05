<?php

namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Seeder;

class TopTokensSeeder extends Seeder
{
    public function run(): void
    {
        $tokens = [
            ['name' => 'Bitcoin', 'symbol' => 'BTC', 'contract_address' => '0x0000000000000000000000000000000000000001', 'decimals' => 8, 'price_usd' => 70000],
            ['name' => 'Ethereum', 'symbol' => 'ETH', 'contract_address' => '0x0000000000000000000000000000000000000002', 'decimals' => 18, 'price_usd' => 3500],
            ['name' => 'Tether USD', 'symbol' => 'USDT', 'contract_address' => '0x0000000000000000000000000000000000000003', 'decimals' => 6, 'price_usd' => 1],
            ['name' => 'BNB', 'symbol' => 'BNB', 'contract_address' => '0x0000000000000000000000000000000000000004', 'decimals' => 18, 'price_usd' => 600],
            ['name' => 'Solana', 'symbol' => 'SOL', 'contract_address' => '0x0000000000000000000000000000000000000005', 'decimals' => 9, 'price_usd' => 180],
            ['name' => 'USD Coin', 'symbol' => 'USDC', 'contract_address' => '0x0000000000000000000000000000000000000006', 'decimals' => 6, 'price_usd' => 1],
            ['name' => 'XRP', 'symbol' => 'XRP', 'contract_address' => '0x0000000000000000000000000000000000000007', 'decimals' => 6, 'price_usd' => 0.60],
            ['name' => 'Cardano', 'symbol' => 'ADA', 'contract_address' => '0x0000000000000000000000000000000000000008', 'decimals' => 6, 'price_usd' => 0.45],
            ['name' => 'Avalanche', 'symbol' => 'AVAX', 'contract_address' => '0x0000000000000000000000000000000000000009', 'decimals' => 18, 'price_usd' => 35],
            ['name' => 'Dogecoin', 'symbol' => 'DOGE', 'contract_address' => '0x0000000000000000000000000000000000000010', 'decimals' => 8, 'price_usd' => 0.12],
            ['name' => 'Polkadot', 'symbol' => 'DOT', 'contract_address' => '0x0000000000000000000000000000000000000011', 'decimals' => 10, 'price_usd' => 7.50],
            ['name' => 'TRON', 'symbol' => 'TRX', 'contract_address' => '0x0000000000000000000000000000000000000012', 'decimals' => 6, 'price_usd' => 0.11],
            ['name' => 'Chainlink', 'symbol' => 'LINK', 'contract_address' => '0x0000000000000000000000000000000000000013', 'decimals' => 18, 'price_usd' => 15],
            ['name' => 'Polygon', 'symbol' => 'MATIC', 'contract_address' => '0x0000000000000000000000000000000000000014', 'decimals' => 18, 'price_usd' => 0.80],
            ['name' => 'Shiba Inu', 'symbol' => 'SHIB', 'contract_address' => '0x0000000000000000000000000000000000000015', 'decimals' => 18, 'price_usd' => 0.000025],
            ['name' => 'Litecoin', 'symbol' => 'LTC', 'contract_address' => '0x0000000000000000000000000000000000000016', 'decimals' => 8, 'price_usd' => 85],
            ['name' => 'Uniswap', 'symbol' => 'UNI', 'contract_address' => '0x0000000000000000000000000000000000000017', 'decimals' => 18, 'price_usd' => 8],
            ['name' => 'Stellar', 'symbol' => 'XLM', 'contract_address' => '0x0000000000000000000000000000000000000018', 'decimals' => 7, 'price_usd' => 0.11],
            ['name' => 'Cosmos', 'symbol' => 'ATOM', 'contract_address' => '0x0000000000000000000000000000000000000019', 'decimals' => 6, 'price_usd' => 10],
            ['name' => 'Filecoin', 'symbol' => 'FIL', 'contract_address' => '0x0000000000000000000000000000000000000020', 'decimals' => 18, 'price_usd' => 6],
        ];

        foreach ($tokens as $token) {
            Token::firstOrCreate(
                ['symbol' => $token['symbol']],
                $token
            );
        }
    }
}