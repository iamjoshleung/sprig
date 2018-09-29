<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Movie;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_returns_its_path() {
        $movie = factory(Movie::class)->create();

        $this->assertEquals(route('cm.movies.destroy', $movie), $movie->getPath());
    }

    /** @test */
    public function it_can_scope_featured_movies() {
        $movie = factory(Movie::class)->create([ 'is_featured' => true ]);

        $this->assertCount(1, Movie::featured()->get());
    }
}
