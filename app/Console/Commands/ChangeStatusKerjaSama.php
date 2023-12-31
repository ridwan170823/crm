<?php

namespace App\Console\Commands;

use App\Models\KerjaSama;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class ChangeStatusKerjaSama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:kerja-sama';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status kerja sama based on tanggal_selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();

        KerjaSama::where('is_active', 1)
            ->where('tanggal_selesai',  $today)
            ->update(['is_active' => false]);

        $this->info('Status kerja sama has been updated');
    }
}
