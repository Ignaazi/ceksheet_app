<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class EnvManager
{
    /**
     * Update or add key-value pair in .env file
     */
    public static function setKey(string $key, string $value): bool
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return false;
        }

        $envContent = File::get($envPath);

        // Bungkus value dengan quote jika mengandung karakter khusus
        $formattedValue = (str_contains($value, ' ') || str_contains($value, ':')) ? "\"{$value}\"" : $value;

        // Cek apakah key sudah ada di file .env
        if (preg_match("/^{$key}=.*/m", $envContent)) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$formattedValue}", $envContent);
        } else {
            $envContent .= "\n{$key}={$formattedValue}";
        }

        File::put($envPath, $envContent);

        return true;
    }
}