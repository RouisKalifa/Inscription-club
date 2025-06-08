<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use App\Models\AccessLog;

class LogAuthenticationAttempt
{
    public function __construct(protected Request $request) {}

    public function handle(object $event): void
    {
        $type = match (get_class($event)) {
            Login::class  => 'login',
            Logout::class => 'logout',
            Failed::class => 'failed',
        };

        AccessLog::create([
            'user_id'    => $event->user->id ?? null,
            'type'       => $type,
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->header('User-Agent'),
        ]);
    }
}
