<?php

namespace BytePlatform\Builder\Models;


class TemplateCategory extends \BytePlatform\Model
{
    public  $table = 'template_categorys';
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
