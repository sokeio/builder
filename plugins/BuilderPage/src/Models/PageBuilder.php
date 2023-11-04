<?php

namespace BytePlugin\BuilderPage\Models;

use BytePlatform\Concerns\WithSlug;
use BytePlatform\Seo\HasSEO;

class PageBuilder extends \BytePlatform\Model
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
