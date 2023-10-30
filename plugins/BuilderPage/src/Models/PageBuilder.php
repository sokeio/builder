<?php

namespace BytePlugin\BuilderPage\Models;

use BytePlatform\Concerns\WithSlug;
use BytePlatform\Seo\HasSEO;

class PageBuilder extends \BytePlatform\Model
{
    use WithSlug;
    use HasSEO;
    public function getUrl()
    {
        return route('page-builder.slug', ['slug' => $this->slug]);
    }
}
