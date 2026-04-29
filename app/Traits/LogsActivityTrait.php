<?php

namespace App\Traits;

use App\Helpers\LogActivity;

trait LogsActivityTrait
{
    /**
     * Log create activity
     */
    protected function logCreate($model, $itemName = null)
    {
        $modelName = class_basename($model);
        $itemName = $itemName ?? ($model->name ?? $model->title ?? $model->id);
        
        LogActivity::log(
            'created',
            $this->getModuleName($modelName),
            $itemName,
            "Created {$modelName}: {$itemName}"
        );
    }

    /**
     * Log update activity
     */
    protected function logUpdate($model, $oldValues, $itemName = null)
    {
        $modelName = class_basename($model);
        $itemName = $itemName ?? ($model->name ?? $model->title ?? $model->id);
        
        LogActivity::log(
            'updated',
            $this->getModuleName($modelName),
            $itemName,
            "Updated {$modelName}: {$itemName}",
            $oldValues,
            $model->getAttributes()
        );
    }

    /**
     * Log delete activity
     */
    protected function logDelete($model, $itemName = null)
    {
        $modelName = class_basename($model);
        $itemName = $itemName ?? ($model->name ?? $model->title ?? $model->id);
        
        LogActivity::log(
            'deleted',
            $this->getModuleName($modelName),
            $itemName,
            "Deleted {$modelName}: {$itemName}",
            $model->getAttributes()
        );
    }

    /**
     * Log view activity
     */
    protected function logView($model, $itemName = null)
    {
        $modelName = class_basename($model);
        $itemName = $itemName ?? ($model->name ?? $model->title ?? $model->id);
        
        LogActivity::log(
            'viewed',
            $this->getModuleName($modelName),
            $itemName,
            "Viewed {$modelName}: {$itemName}"
        );
    }

    /**
     * Get module name from model name
     */
    protected function getModuleName($modelName)
    {
        $moduleMap = [
            'Statistic' => 'statistics',
            'PageBanner' => 'banners',
            'AccomplishmentReport' => 'accomplishment-reports',
            'Chart' => 'charts',
            'Announcement' => 'announcements',
            'OrganizationMember' => 'organization-members',
            'Program' => 'programs',
            'Document' => 'documents',
            'GADSubmission' => 'gad-submissions',
            'GADAgenda' => 'gad-agendas',
            'GADGuideline' => 'gad-guidelines',
        ];

        return $moduleMap[$modelName] ?? strtolower($modelName);
    }
}
