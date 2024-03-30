<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TelnetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Connect to the Telnet server.
     *
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param string $command
     * @return string
     */
    public function connectTelnet($host, $port, $username, $password, $command)
    {
        // Membuka koneksi Telnet
        $socket = fsockopen($host, $port, $errno, $errstr, 10);

        if (!$socket) {
            return "Error: $errstr ($errno)\n";
        } else {
            // Membaca respons awal (login prompt)
            $data = fread($socket, 8192);

            // Mengirimkan username
            fwrite($socket, $username . "\r\n");

            // Membaca respons (password prompt)
            $data = fread($socket, 8192);

            // Mengirimkan password
            fwrite($socket, $password . "\r\n");

            // Membaca respons (prompt setelah login berhasil)
            $data = fread($socket, 8192);

            // Mengirimkan perintah
            fwrite($socket, $command . "\r\n");

            // Membaca dan menampilkan respons
            $data = fread($socket, 8192);

            // Menutup koneksi
            fclose($socket);

            return $data;
        }
    }
}
