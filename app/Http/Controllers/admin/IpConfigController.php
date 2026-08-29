<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class IpConfigController extends Controller
{
    /**
     * Menampilkan Halaman Configure IP
     */
    public function index()
    {
        // 1. Ambil IP dari server request jika diakses via IP LAN
        $serverIp = $_SERVER['SERVER_ADDR'] ?? null;

        // 2. Jika tidak ada/loopback, gunakan deteksi Hostname
        if (!$serverIp || $serverIp === '127.0.0.1' || $serverIp === '::1') {
            $serverIp = gethostbyname(gethostname());
        }

        // 3. Fallback terakhir jika masih loopback
        if ($serverIp === '127.0.0.1' || $serverIp === '::1') {
            $serverIp = '192.168.1.1'; // IP default jika offline total
        }

        // Ambil APP_URL saat ini dari config
        $currentAppUrl = config('app.url');

        return view('admin.ipConfig', compact('serverIp', 'currentAppUrl'));
    }

    /**
     * Menyimpan Konfigurasi IP / Domain Baru ke .env
     */
    public function update(Request $request)
    {
        $request->validate([
            'connection_type' => 'required|in:lan,tunnel',
            'ip_address'      => 'nullable|string',
            'port'            => 'nullable|numeric',
            'tunnel_url'      => 'nullable|url',
        ]);

        if ($request->connection_type === 'lan') {
            $ip = $request->ip_address ?: gethostbyname(gethostname());
            $port = $request->port ? ":{$request->port}" : ':8000';
            // Pastikan tidak ada double colon jika port diisi dengan ":"
            $port = str_starts_with($port, ':') ? $port : ":{$port}";
            $newUrl = "http://{$ip}{$port}";
        } else {
            $newUrl = rtrim($request->tunnel_url, '/');
        }

        // Update nilai APP_URL di .env menggunakan method internal
        $this->setEnvKey('APP_URL', $newUrl);

        // Clear cache config Laravel agar settingan baru langsung berefek
        Artisan::call('config:clear');

        return redirect()->route('ip-config.index')->with('status', 'ip-updated');
    }

    /**
     * Helper Method Internal untuk Mengubah Nilai di File .env
     */
    private function setEnvKey(string $key, string $value): bool
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return false;
        }

        $envContent = File::get($envPath);

        // Bungkus value dengan petik jika mengandung titik dua atau spasi (seperti URL)
        $formattedValue = (str_contains($value, ' ') || str_contains($value, ':')) ? "\"{$value}\"" : $value;

        // Cari key dan ganti nilainya, atau tambahkan di paling bawah jika belum ada
        if (preg_match("/^{$key}=.*/m", $envContent)) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$formattedValue}", $envContent);
        } else {
            $envContent .= "\n{$key}={$formattedValue}";
        }

        File::put($envPath, $envContent);

        return true;
    }
}