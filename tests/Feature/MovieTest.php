<?php

namespace Tests\Feature;

use App\User;
use App\Movie;
use Exception;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        Storage::fake('minio');

        visits(Movie::class)->reset();
    }

    /** @test */
    public function non_admin_cannot_create_movies()
    {
        $this->post(route('cm.movies.store'), [])->assertRedirect(route('cm.login'));
    }

    /** @test */
    public function admin_can_create_movies()
    {

        $this->signInAsAdmin();

        $movie = $this->postMovie();

        $this->assertCount(1, Movie::all());
        $this->assertCount(1, $movie->getMedia('cover'));
        $this->assertCount(2, $movie->getMedia('previews'));
    }

    /** @test */
    public function non_admin_cannot_remove_movies()
    {
        $movie = factory(Movie::class)->create();

        $this->deleteJson($movie->getPath())
            ->assertStatus(401);
    }

    /** @test */
    public function admin_can_remove_a_movie()
    {
        $this->signInAsAdmin();

        $movie = factory('App\Movie')->create();

        $this->deleteJson($movie->getPath())
            ->assertStatus(204);

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id
        ]);
    }

    /** @test */
    public function non_admin_cannot_modify_movies()
    {
        $movie = factory('App\Movie')->create();

        $this->patchJson($movie->getPath())
            ->assertStatus(401);
    }

    /** @test */
    public function admin_can_modify_a_movie()
    {
        $this->signInAsAdmin();

        $movie = factory('App\Movie')->create();

        $this->patchJson($movie->getPath(), [
            'title' => 'updated title',
            'download_link' => $movie->download_link,
            'cover_image' => UploadedFile::fake()->image('cover_image.jpg'),
            'preview_images' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg')
            ]
        ])
            ->assertStatus(200);

        $this->assertEquals('updated title', $movie->fresh()->title);
        $this->assertCount(1, Movie::first()->getMedia('cover'));
        $this->assertCount(2, Movie::first()->getMedia('previews'));
    }

    /** @test */
    public function a_movie_cannot_have_more_than_one_cover_image() {
        $this->signInAsAdmin();

        $movie = $this->postMovie();

        $this->expectException(Exception::class);

        $this->patchJson($movie->getPath(), [
            'title' => 'updated title',
            'cover_image' => UploadedFile::fake()->image('cover_image2.jpg'),
        ])->assertStatus(401);
    }

    /** @test */
    public function a_movie_can_be_added_with_more_preview_images_after_created() {
        $this->signInAsAdmin();

        $movie = $this->postMovie();

        $this->patchJson($movie->getPath(), [
            'title' => 'updated title',
            'download_link' => $movie->download_link,
            'preview_images' => [
                UploadedFile::fake()->image('preview1.jpg'),
                UploadedFile::fake()->image('preview2.jpg')
            ],
        ])->assertStatus(200);

        $this->assertCount(4, $movie->fresh()->getMedia('previews'));
    }

    /** @test */
    public function admin_can_remove_the_cover_image_from_a_movie() {
        $this->signInAsAdmin();

        $movie = $this->postMovie();

        $this->deleteJson($movie->getPath() . "/cover/{$movie->getMedia('cover')[0]->id}")->assertStatus(204);
        $this->assertCount(0, $movie->fresh()->getMedia('cover'));
    }

    /** @test */
    public function admin_can_remove_a_preview_image_from_a_movie() {
        $this->signInAsAdmin();

        $movie = $this->postMovie();

        $firstPreview = $movie->getMedia('previews')[0];
        $secondPreview = $movie->getMedia('previews')[1];

        $this->deleteJson($movie->getPath() . "/previews/{$firstPreview->id}")->assertStatus(204);

        $this->assertCount(1, $movie->fresh()->getMedia('previews'));

        $newFirstPreview = $movie->fresh()->getMedia('previews')[0];
        $this->assertNotEquals($firstPreview->id, $newFirstPreview->id);
    }

    /** @test */
    public function users_can_fetch_a_movie_from_the_db()
    {
        $this->signInAsAdmin();

        $data = [
            'title' => 'Some title',
            'issuer' => 'Some issuer',
            'released_at' => '2018-05-07',
            'desc' => 'Some desc',
            'download_link' => 'http://website.com/download/xxx',
            'cover_image' => UploadedFile::fake()->image('cover_image.jpg'),
            'preview_images' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg')
            ]
        ];

        $this->postJson(route('cm.movies.store'), $data)->assertStatus(201);

        $movie = Movie::first();

        // dd($this->getJson($movie->getPath())->json());

        $this->getJson($movie->getPath())
            ->assertJsonStructure([
                'id',
                'title',
                'issuer',
                'desc',
                'download_link',
                'released_at',
                'images' => [
                    'cover' => [
                        'id',
                        'url',
                        'html'
                    ],
                    'previews' => [
                        [
                            'id',
                            'url',
                            'html'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function admin_can_view_a_list_of_movies()
    {
        $this->signInAsAdmin();

        factory('App\Movie', 20)->create();

        $res = $this->getJson('/cm/movies');
        $data = $res->json();

        $res->assertStatus(200);
        $this->assertCount(10, $data['data']);
    }

    /** @test */
    public function it_records_visit_count() {
        $this->signInAsAdmin();
        
        $movie = $this->postMovie();

        $this->getJson(route('movies.show', $movie));

        $this->assertEquals(1, $movie->fresh()->getVisitCount());

        $this->getJson(route('movies.show', $movie));

        // dd(Movie::first()->getVisitCount());

        $this->assertEquals(2, $movie->fresh()->getVisitCount());
    }

    /** @test */
    public function it_returns_today_top_movies() {
        $movies = factory(Movie::class,10)->create();

        $this->visitMovie($movies[0], $times = 10);
        $this->visitMovie($movies[3], $times = 9);
        $this->visitMovie($movies[2], $times = 8);
        $this->visitMovie($movies[1], $times = 7);
        $this->visitMovie($movies[9], $times = 6);
        $this->visitMovie($movies[8], $times = 5);
        $this->visitMovie($movies[7], $times = 4);
        $this->visitMovie($movies[6], $times = 3);
        $this->visitMovie($movies[5], $times = 2);
        $this->visitMovie($movies[4], $times = 1);

        $this->assertCount(7, Movie::getTopMovies());
        $this->assertArraySubset([
            $movies[0]->id,
            $movies[3]->id,
            $movies[2]->id,
            $movies[1]->id,
            $movies[9]->id,
            $movies[8]->id,
            $movies[7]->id,
        ], Movie::getTopMovies()->pluck('id'));
    }

    protected function postMovie() {
        $data = [
            'title' => 'Some title',
            'issuer' => 'Some issuer',
            'released_at' => '2018-05-07',
            'desc' => 'Some desc',
            'download_link' => 'http://website.com/download/xxx',
            'cover_image' => UploadedFile::fake()->image('cover_image.jpg'),
            'is_featured' => '0',
            'preview_images' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg')
            ]
        ];

        $res = $this->postJson(route('cm.movies.store'), $data);
        return Movie::find($res->json()['id']);
    }

    protected function visitMovie($movie, $times) {
        for($i = 0; $i < $times; $i++) {
            $movie->increaseVisitCount();
        }
    }
}
