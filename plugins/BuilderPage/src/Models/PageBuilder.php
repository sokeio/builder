<?php

namespace SokeioPlugin\BuilderPage\Models;

use Sokeio\Concerns\WithSlug;
use Sokeio\Seo\HasSEO;

class PageBuilder extends \Sokeio\Model
{
    use WithSlug;
    use HasSEO;
    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
    public function getUrl()
    {
        return route('page-builder.slug', ['slug' => $this->slug]);
    }
}
