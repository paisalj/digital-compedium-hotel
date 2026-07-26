<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class DeleteOldCategories extends Command
{
    protected $signature = 'categories:auto-delete';

    protected $description = 'Hapus permanen kategori yang berada di recycle bin lebih dari 30 hari';

    public function handle()
    {
        $deleted = Category::onlyTrashed()
            ->where('deleted_at', '<=', now()->subDays(30))
            ->forceDelete();

        $this->info("{$deleted} kategori berhasil dihapus permanen.");

        return self::SUCCESS;
    }
}