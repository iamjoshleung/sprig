<?php

namespace Tests\Unit;

use stdClass;
use Carbon\Carbon;
use Tests\TestCase;
use App\Services\TumblrFilter;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TumblrFilterTest extends TestCase
{

    /** @test */
    public function it_filters_out_posts_older_than_last_scrapped_timestamp()
    {
        $last_scrapped_at = now()->subMonth();

        $post1 = new stdClass();
        $post1->timestamp = now()->timestamp;

        $post2 = new stdClass();
        $post2->timestamp = now()->subMonths(2)->timestamp;

        $posts = [
            $post1, $post2
        ];

        $filter = new TumblrFilter($last_scrapped_at, $posts);

        $filteredPosts = $filter->filterOldPosts();

        $this->assertCount(1, $filteredPosts);
    }

    /** @test */
    public function it_transfroms_tumblr_image_posts_into_structured_array()
    {
        // make stdClass instance
        $posts = json_decode('[{"type":"photo","id":175794735018,"post_url":"http://puppiestotherescue.tumblr.com/post/175794735018","date":"2018-07-11 23:30:13 GMT","timestamp":1531351813,"trail":[],"image_permalink":"http://puppiestotherescue.tumblr.com/image/175794735018","photos":[{"caption":"","original_size":{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_1280.jpg","width":1150,"height":1350},"alt_sizes":[{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_1280.jpg","width":1150,"height":1350},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_640.jpg","width":640,"height":751},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_540.jpg","width":540,"height":634},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_500.jpg","width":500,"height":587},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_400.jpg","width":400,"height":470},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_250.jpg","width":250,"height":293},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_100.jpg","width":100,"height":117},{"url":"https://78.media.tumblr.com/8de81ee3c9b10eda71fc1d5aba3a48f4/tumblr_p6sreryByc1tbwj7ho1_75sq.jpg","width":75,"height":75}]}]}]');

        $last_scrapped_at = Carbon::createFromTimestamp(1531351813)->subMonth();

        $filter = new TumblrFilter($last_scrapped_at, $posts);

        $filteredPosts = $filter->filterOldPosts();

        $images = $filter->getFilteredImages($filteredPosts);

        $this->assertCount(1, $images);
        $this->assertCount(1, $images[0]);
    }

    /** @test */
    public function it_returns_image_gallery_into_a_strucutred_array() {
        $posts = json_decode('[{"type":"photo","blog_name":"ianloveasianmen","id":176122772527,"post_url":"http://ianloveasianmen.tumblr.com/post/176122772527","slug":"","date":"2018-07-21 13:11:14 GMT","timestamp":1532178674,"state":"published","format":"html","reblog_key":"4bgDt83H","tags":[],"short_url":"https://tmblr.co/Z5JMfl2a1l3ml","summary":"","is_blocks_post_format":true,"recommended_source":null,"recommended_color":null,"note_count":469,"source_url":"https://a-mackenyu.tumblr.com/post/176088047502","source_title":"a-mackenyu","caption":"","reblog":{"comment":"","tree_html":""},"trail":[],"photoset_layout":"131","photos":[{"caption":"","original_size":{"url":"https://78.media.tumblr.com/0f3516a3df14234a23bd5ab75be4be49/tumblr_pc5zo01RU41x6cq7bo1_400.jpg","width":400,"height":396},"alt_sizes":[{"url":"https://78.media.tumblr.com/0f3516a3df14234a23bd5ab75be4be49/tumblr_pc5zo01RU41x6cq7bo1_400.jpg","width":400,"height":396},{"url":"https://78.media.tumblr.com/0f3516a3df14234a23bd5ab75be4be49/tumblr_pc5zo01RU41x6cq7bo1_250.jpg","width":250,"height":248},{"url":"https://78.media.tumblr.com/0f3516a3df14234a23bd5ab75be4be49/tumblr_pc5zo01RU41x6cq7bo1_100.jpg","width":100,"height":99},{"url":"https://78.media.tumblr.com/0f3516a3df14234a23bd5ab75be4be49/tumblr_pc5zo01RU41x6cq7bo1_75sq.jpg","width":75,"height":75}]},{"caption":"","original_size":{"url":"https://78.media.tumblr.com/04ab22a6d2041fe20655e8990a4ed87d/tumblr_pc5zo01RU41x6cq7bo2_400.jpg","width":400,"height":499},"alt_sizes":[{"url":"https://78.media.tumblr.com/04ab22a6d2041fe20655e8990a4ed87d/tumblr_pc5zo01RU41x6cq7bo2_400.jpg","width":400,"height":499},{"url":"https://78.media.tumblr.com/04ab22a6d2041fe20655e8990a4ed87d/tumblr_pc5zo01RU41x6cq7bo2_250.jpg","width":250,"height":312},{"url":"https://78.media.tumblr.com/04ab22a6d2041fe20655e8990a4ed87d/tumblr_pc5zo01RU41x6cq7bo2_100.jpg","width":100,"height":125},{"url":"https://78.media.tumblr.com/04ab22a6d2041fe20655e8990a4ed87d/tumblr_pc5zo01RU41x6cq7bo2_75sq.jpg","width":75,"height":75}]},{"caption":"","original_size":{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_1280.jpg","width":720,"height":1280},"alt_sizes":[{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_1280.jpg","width":720,"height":1280},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_640.jpg","width":540,"height":960},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_540.jpg","width":456,"height":810},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_500.jpg","width":422,"height":750},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_400.jpg","width":338,"height":600},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_250.jpg","width":225,"height":400},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_100.jpg","width":100,"height":178},{"url":"https://78.media.tumblr.com/1cbeb96714386312f6ea386a4f6b9bb0/tumblr_pc5zo01RU41x6cq7bo3_75sq.jpg","width":75,"height":75}]},{"caption":"","original_size":{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_1280.jpg","width":720,"height":1280},"alt_sizes":[{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_1280.jpg","width":720,"height":1280},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_640.jpg","width":540,"height":960},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_540.jpg","width":456,"height":810},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_500.jpg","width":422,"height":750},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_400.jpg","width":338,"height":600},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_250.jpg","width":225,"height":400},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_100.jpg","width":100,"height":178},{"url":"https://78.media.tumblr.com/31062f7b4a485f8e4054821cc3af9f06/tumblr_pc5zo01RU41x6cq7bo4_75sq.jpg","width":75,"height":75}]},{"caption":"","original_size":{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_540.jpg","width":540,"height":672},"alt_sizes":[{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_540.jpg","width":540,"height":672},{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_500.jpg","width":500,"height":622},{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_400.jpg","width":400,"height":498},{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_250.jpg","width":250,"height":311},{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_100.jpg","width":100,"height":124},{"url":"https://78.media.tumblr.com/ddfff87785b1827e056f7c194f882754/tumblr_pc5zo01RU41x6cq7bo5_75sq.jpg","width":75,"height":75}]}]}]');

          $last_scrapped_time = now()->subMonth();

          $filter = new TumblrFilter($last_scrapped_time, $posts);

          $filteredPosts = $filter->filterOldPosts();

          $images = $filter->getFilteredImages($filteredPosts);

          $this->assertCount(1, $images);
          $this->assertCount(5, $images[0]);
    }
}
