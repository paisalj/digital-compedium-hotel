<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupOldMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-old-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    // Cari media yang sudah di-trash lebih dari 30 hari
    $oldMedia = \App\Models\Media::onlyTrashed()
        ->where('deleted_at', '<=', now()->subDays(30))
        ->get();

    foreach ($oldMedia as $item) {
        \Storage::delete($item->file_path); // Hapus file fisik
        $item->forceDelete(); // Hapus dari database
    }

    $this->info('Media lama berhasil dibersihkan.');
}
}
