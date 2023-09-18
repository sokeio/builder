<?php

namespace BytePlatform\Builder\Livewire;

use BytePlatform\Component;
use BytePlatform\Facades\Theme;

class TestPage extends Component{
    public function render(){
        Theme::setLayout('none');
        return view('builder::testpage');
    }
}