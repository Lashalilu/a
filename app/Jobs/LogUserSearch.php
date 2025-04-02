<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\UserSearch;

class LogUserSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $keyword;

    public function __construct($userId, $keyword)
    {
        $this->userId = $userId;
        $this->keyword = $keyword;
    }

    public function handle()
    {
        $userSearch = UserSearch::firstOrNew([
            'user_id' => $this->userId,
            'keyword' => $this->keyword,
        ]);

        $userSearch->quantity = $userSearch->exists ? $userSearch->quantity + 1 : 1;
        $userSearch->save();
    }
}
