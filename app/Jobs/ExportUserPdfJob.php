<?php

namespace App\Jobs;

use App\Events\UserCsvCreated;
use App\Events\UserPdfCreated;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportUserPdfJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Collection|LengthAwarePaginator $users)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filename = now()->timestamp . '.pdf';

        $pdf = Pdf::loadView('pdf.generate', ['users' => $this->users]);

        Storage::disk('s3')->put($filename, $pdf->output());

        broadcast(new UserPdfCreated(Storage::disk('s3')->url($filename)));
    }
}
