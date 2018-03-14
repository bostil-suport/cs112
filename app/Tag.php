<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class Tag extends Model
{
    /**
     * Fillable fields for a tag.
     * @var array
     */
    protected $fillable = [
        'name',

    ];



    /**
     * Get the projects associated with the given tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function projects ()
    {
        return $this->belongsToMany('App\Project');
    }

    /**
     * Get a list of project ids associated with the current project.
     * @return array
     */
//    public function getProjectListAttribute()
//    {
//        return $this->projects->pluck('project_id');
//
//    }



}
