<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class FirstTest extends TestCase
{
    public $id = 5;
    /**
     *  Get projects
     *
     * @return void
     */
    public function testGetProjects()
    {
        $this->assertTrue(true);
        $projects = Project::orderBy('id')->get()->all();
        $i = 0;

        foreach ($projects as $item) {
            $pr[$i]['id'] = $item->id;
            $pr[$i]['title'] = $item->title;
            $pr[$i]['description'] = $item->description;
            $this->assertEquals($pr[$i]['title'], $item->title);
            $i++;

        }
//        print_r($pr);


    }

    public function testOneProject()
    {
        $project = Project::where('id', 5)->first();
        $this->assertEquals(5, $project->id);
    }
}
