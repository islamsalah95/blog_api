<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchAndLogRandomUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Make the HTTP request to the endpoint
        $response = Http::get('https://randomuser.me/api/');

        // Check if the request was successful
        if ($response->successful()) {
            // Get the 'results' object from the response
            $results = $response->json('results');

            // Log the results
            Log::info('Random User API Results:', $results);
        } else {
            // Log an error message if the request failed
            Log::error('Failed to fetch data from Random User API.');
        }
    }
}
