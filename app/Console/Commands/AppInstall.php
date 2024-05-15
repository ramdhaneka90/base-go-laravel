<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('');
        $this->info('[ Migrate DB ]');
        if ($this->confirm('Do you wish to run migration?')) {
            $this->call('migrate:refresh');
        }

        $this->call('acl:generate');

        $this->info('');
        $this->info('[ Run Seeder ]');
        if ($this->confirm('Do you wish to run seeder?')) {
            $this->call('db:seed');
        }
    }
}
