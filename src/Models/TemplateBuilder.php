<?php

namespace Sokeio\Builder\Models;


class TemplateBuilder extends \Sokeio\Model
{
    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
