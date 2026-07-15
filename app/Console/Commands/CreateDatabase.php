<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class CreateDatabase extends Command
{
    protected $signature = 'db:create {name?}';
    protected $description = 'Create the database specified in .env or given as parameter';

    public function handle()
    {
        $dbName = $this->argument('name') ?? env('DB_DATABASE');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');

        try {
            $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPassword);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $this->info("Database '$dbName' berhasil dibuat atau sudah ada.");
        } catch (PDOException $e) {
            $this->error("Gagal membuat database: " . $e->getMessage());
        }
    }
}
