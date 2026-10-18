<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class GlobalObserver
{
    public function created(Model $model) { $this->log('create', $model); }
    public function updated(Model $model) { $this->log('update', $model); }
    public function deleted(Model $model) { $this->log('delete', $model); }

    private function log($action, Model $model)
    {
        // Mendapatkan nama class model (contoh: App\Models\User -> User)
        $module = class_basename($model);
        
        ActivityLog::create([
            'user_id'     => Auth::id() ?? 1,
            'module'      => $module,
            'action'      => $action,
            'description' => $module . ' ID ' . $model->id . ' telah di-' . $action,
            'ip_address'  => request()->ip(),
        ]);
    }
}