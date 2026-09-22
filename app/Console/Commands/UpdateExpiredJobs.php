<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;

class UpdateExpiredJobs extends Command
{
    
    protected $signature = 'jobs:update-expired';

    protected $description = 'Tự động cập nhật trạng thái các job đã quá hạn (qua deadline) sang ngưng hoạt động';

    public function handle()
    {
        $today = Carbon::today(); 

        $updatedCount = Job::where('status', true)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', $today)
            ->update(['status' => false]);

        $this->info("Đã cập nhật thành công {$updatedCount} job hết hạn.");
    }
}