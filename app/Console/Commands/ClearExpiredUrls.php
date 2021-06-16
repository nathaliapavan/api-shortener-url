<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Url;
use Carbon\Carbon;

class ClearExpiredUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:clear_expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear URLs expired 7 days ago';

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
     * @return int
     */
    public function handle() {
        Url::where('expiration_date', '<', Carbon::now())->each(function ($url) {
            $url->delete();
        });
    }
}

//* * * * * cd /shortener-url && php artisan schedule:run >> /dev/null 2>&1
// run comand php artisan url:clear_expired
