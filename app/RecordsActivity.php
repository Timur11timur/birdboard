<?php


namespace App;


trait RecordsActivity
{
    /**
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait
     */
    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated') {
                static::updating(function($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    protected static function recordableEvents()
    {
        return static::$recordableEvents ?? ['created', 'updated', 'deleted'];
    }

    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    protected function activityChanges()
    {
        if($this->wasChanged()) {
            return [
                'before' => $this->excludeUpdatedAt(array_diff($this->oldAttributes, $this->getAttributes())),
                'after' => $this->excludeUpdatedAt($this->getChanges()),
            ];
        }
    }

    private function excludeUpdatedAt($array)
    {
        unset($array['updated_at']);
        return $array;
    }
}