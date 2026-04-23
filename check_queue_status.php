<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Checking job queue status...\n\n";
    
    // Check jobs table
    $jobs = DB::table('jobs')->get();
    echo "Jobs in queue: " . count($jobs) . "\n";
    foreach ($jobs as $job) {
        echo "  - ID: {$job->id}, Queue: {$job->queue}, Attempts: {$job->attempts}\n";
    }
    
    // Check failed_jobs table
    $failedJobs = DB::table('failed_jobs')->get();
    echo "\nFailed jobs: " . count($failedJobs) . "\n";
    foreach ($failedJobs as $job) {
        echo "  - ID: {$job->id}, Status: {$job->failed_at}\n";
    }
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
