<?php

namespace BytePlatform\Builder\Models;


class TemplateBuilder extends \BytePlatform\Model
{
    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
