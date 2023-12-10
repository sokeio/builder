<?php

namespace Sokeio\Builder;

use Sokeio\Admin\ItemCallback;
use Illuminate\Contracts\Support\Arrayable;

class CollectionBlock extends ItemCallback  implements Arrayable
{
    protected function Catalog()
    {
        return 'Common';
    }
    protected function getBlocks(): array
    {
        return [];
    }
    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return collect($this->getBlocks())->map(function ($item) {
            $item->Category($this->Catalog());
            return $item;
        })->toArray();
    }
   
    public static function getBlockArray()
    {
        return static::New()->toArray();
    }
}
