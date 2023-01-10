<?php

namespace App\Service\Parcel\Jobs;

use App\Models\Parcel;
use App\Service\Parcel\StatusWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StatusWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private StatusWebhookService $statusWebhookService;
    private Parcel $parcel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Parcel $parcel)
    {
        $this->statusWebhookService = app(StatusWebhookService::class);
        $this->parcel = $parcel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->statusWebhookService->dispatchStatusToCompany($this->parcel);
    }
}
