<?php

namespace BytePlugin\BuilderPage\Models;

use BytePlatform\Concerns\WithSlug;
use BytePlatform\Seo\HasSEO;

class PageBuilder extends \BytePlatform\Model
{
    use WithSlug;
    use HasSEO;
}
