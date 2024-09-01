<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteOldPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get the date 30 days ago
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Retrieve all posts that were softly deleted more than 30 days ago
        $oldPosts = Post::onlyTrashed()->where('deleted_at', '<=', $thirtyDaysAgo)->get();

        // Force delete the posts
        foreach ($oldPosts as $post) {
            $post->forceDelete();
        }
    }
}

