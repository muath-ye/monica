<?php

namespace App\Jobs\AuditLog;

use App\Services\Instance\AuditLog\LogAccountAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LogAccountAudit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The audit log instance.
     *
     * @var array
     */
    public $auditLog;

    /**
     * Create a new job instance.
     *
     * @param array $auditLog
     */
    public function __construct(array $auditLog)
    {
        $this->auditLog = $auditLog;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new LogAccountAction)->execute([
            'account_id' => $this->auditLog['account_id'],
            'author_id' => $this->auditLog['author_id'],
            'author_name' => $this->auditLog['author_name'],
            'audited_at' => $this->auditLog['audited_at'],
            'action' => $this->auditLog['action'],
            'objects' => $this->auditLog['objects'],
        ]);
    }
}
