<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Project extends Model
{

    /**
     * Get the user associated with the given project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function users()
    {

        return $this->belongsTo('App\User');
    }


    /**
     * Get the tags associated with the given project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {

        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     * Get a list of tag ids associated with the current project.
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id');

    }




}
