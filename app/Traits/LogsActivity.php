<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait and attach model event listeners
     */
    protected static function bootLogsActivity()
    {
        // Log when model is created
        static::created(function ($model) {
            $model->logActivity('created', $model->getChanges());
        });

        // Log when model is updated
        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (!empty($changes)) {
                $model->logActivity('updated', $changes, $model->getOriginal());
            }
        });

        // Log when model is deleted
        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->getOriginal());
        });
    }

    /**
     * Log activity to database
     */
    protected function logActivity($action, $newData = [], $oldData = [])
    {
        // Get model name without namespace
        $modelName = class_basename(get_class($this));
        
        // Get user if authenticated (for new user registration, user_id will be null)
        $userId = Auth::check() ? Auth::id() : null;
        
        // Get model identifier (ID or name)
        $identifier = $this->name ?? $this->id ?? 'Unknown';
        
        // Build description
        $description = match($action) {
            'created' => "{$modelName} '{$identifier}' telah dibuat" . ($userId ? '' : ' (Registrasi baru)'),
            'updated' => "{$modelName} '{$identifier}' telah diupdate",
            'deleted' => "{$modelName} '{$identifier}' telah dihapus",
            default => "{$modelName} '{$identifier}' - {$action}",
        };

        // Filter sensitive data
        $sensitiveFields = ['password', 'remember_token', 'api_token'];
        foreach ($sensitiveFields as $field) {
            unset($newData[$field], $oldData[$field]);
        }

        // Create activity log
        ActivityLog::create([
            'user_id' => $userId, // Will be null for new user registration
            'action' => $action,
            'model_type' => $modelName,
            'model_id' => $this->id,
            'description' => $description,
            'old_data' => !empty($oldData) ? json_encode($oldData) : null,
            'new_data' => !empty($newData) ? json_encode($newData) : null,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Get activity logs for this model instance
     */
    public function activityLogs()
    {
        return ActivityLog::where('model_type', class_basename(get_class($this)))
            ->where('model_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
