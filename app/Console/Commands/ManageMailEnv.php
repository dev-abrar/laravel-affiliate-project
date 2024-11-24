<?php
// app/Console/Commands/ManageMailEnv.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ManageMailEnv extends Command
{
    protected $signature = 'env:manage-mail {action} {key?} {value?}';
    protected $description = 'Manage mail settings in .env file via form submission (CRUD operations)';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = $this->argument('action');
        $key = $this->argument('key');
        $value = $this->argument('value');

        switch ($action) {
            case 'get':
                $this->getEnv($key);
                break;

            case 'set':
                $this->setEnv($key, $value);
                break;

            case 'delete':
                $this->deleteEnv($key);
                break;

            case 'list':
                $this->listEnv();
                break;

            default:
                $this->error("Invalid action. Please use 'get', 'set', 'delete', or 'list'.");
        }
    }

    // Read value from .env file
    public function getEnv($key)
    {
        $value = env($key);
        if ($value !== null) {
            $this->info("The value of '$key' is: $value");
        } else {
            $this->error("No value found for key '$key'.");
        }
    }

    // Set a value in the .env file
    public function setEnv($key, $value)
    {
        $envFile = base_path('.env');
        if (!File::exists($envFile)) {
            $this->error('.env file not found!');
            return;
        }

        $envContent = File::get($envFile);
        $keyExists = preg_match("/^$key=/m", $envContent);

        if ($keyExists) {
            $envContent = preg_replace("/^$key=.*/m", "$key=$value", $envContent);
        } else {
            $envContent .= "\n$key=$value";
        }

        File::put($envFile, $envContent);
        $this->info("Environment variable '$key' has been set to '$value'.");
    }

    // Delete a key from the .env file
    public function deleteEnv($key)
    {
        $envFile = base_path('.env');
        if (!File::exists($envFile)) {
            $this->error('.env file not found!');
            return;
        }

        $envContent = File::get($envFile);
        $envContent = preg_replace("/^$key=.*\n?/m", "", $envContent);

        File::put($envFile, $envContent);
        $this->info("Environment variable '$key' has been deleted.");
    }

    // List all mail-related environment variables
    public function listEnv()
    {
        $envFile = base_path('.env');
        if (!File::exists($envFile)) {
            $this->error('.env file not found!');
            return;
        }

        $envContent = File::get($envFile);
        $lines = explode("\n", $envContent);

        $this->info("Listing mail related environment variables:");
        foreach ($lines as $line) {
            if (strpos($line, 'MAIL_') !== false) {
                $this->line($line);
            }
        }
    }
}


