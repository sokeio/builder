<?php

namespace Sokeio\Builder\Models;


class TemplateCategory extends \Sokeio\Model
{
    public  $table = 'template_categorys';
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
