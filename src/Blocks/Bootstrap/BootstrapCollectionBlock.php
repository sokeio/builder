<?php

namespace BytePlatform\Builder\Blocks\Bootstrap;

use BytePlatform\Builder\Blocks\Bootstrap\AlertBlock;
use BytePlatform\Builder\CollectionBlock;

class BootstrapCollectionBlock extends CollectionBlock
{
    protected function Catalog()
    {
        return 'Bootstrap';
    }
    protected function getBlocks(): array
    {
        return [
            AlertBlock::New()
        ];
    }
}
