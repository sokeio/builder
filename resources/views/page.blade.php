<div class="byte-builder-manager">
    <div class="byte-builder-header">
        <div class="byte-builder-header__left">
            <div class="byte-builder-logo">BYTE BUILDER <span>v1.0.0</span></div>
        </div>
        <div class="byte-builder-header__center">
            <div class="devices-panel-manager"></div>
        </div>
        <div class="byte-builder-header__right">
            <div class="options-panel-manager"></div>
        </div>
    </div>
    <div class="byte-builder-body">
        <div class="byte-builder-control" x-data="{
            controlTabIndex: 0,
            controlChooseTab: function(tab) {
                if (tab == this.controlTabIndex) {
                    this.controlTabIndex = -1;
                    return;
                } else {
                    this.controlTabIndex = tab;
                }
            }
        }">
            <div class="byte-builder-control__list">
                <div title="Block Manager" @click="controlChooseTab(0)" :class="controlTabIndex == 0 ? 'active' : ''"
                    class="byte-builder-control__list--item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-apps" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        <path d="M14 7l6 0"></path>
                        <path d="M17 4l0 6"></path>
                    </svg>
                </div>
                <div title="Template Manager" @click="controlChooseTab(1)" :class="controlTabIndex == 1 ? 'active' : ''"
                    class="byte-builder-control__list--item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-carousel-vertical"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M19 8v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1z"></path>
                        <path d="M7 22v-1a1 1 0 0 1 1 -1h8a1 1 0 0 1 1 1v1"></path>
                        <path d="M17 2v1a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-1"></path>
                    </svg>
                </div>
                <div title="Setting Page" @click="controlChooseTab(2)" :class="controlTabIndex == 2 ? 'active' : ''"
                    class="byte-builder-control__list--item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-table-options"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7"></path>
                        <path d="M3 10h18"></path>
                        <path d="M10 3v18"></path>
                        <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path d="M19.001 15.5v1.5"></path>
                        <path d="M19.001 21v1.5"></path>
                        <path d="M22.032 17.25l-1.299 .75"></path>
                        <path d="M17.27 20l-1.3 .75"></path>
                        <path d="M15.97 17.25l1.3 .75"></path>
                        <path d="M20.733 20l1.3 .75"></path>
                    </svg>
                </div>
                <div title="Plugin Manager" @click="controlChooseTab(3)" :class="controlTabIndex == 3 ? 'active' : ''"
                    class="byte-builder-control__list--item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-puzzle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1"></path>
                     </svg>
                </div>
            </div>
            <div class="byte-builder-control__content">
                <div x-show="controlTabIndex==0" class="byte-builder-control__content--item">
                    <h3>Block Manager</h3>
                    <div class="manager-body block-manager">
                    </div>
                </div>
                <div x-show="controlTabIndex==1" class="byte-builder-control__content--item">
                    <h3>Template Manager</h3>
                    <div class="manager-body template-page-manager">
                    </div>
                </div>
                <div x-show="controlTabIndex==2" class="byte-builder-control__content--item">
                    <h3>Setting Page</h3>
                    <div class="manager-body setting-page-manager">
                    </div>
                </div>
                <div x-show="controlTabIndex==3" class="byte-builder-control__content--item">
                    <h3>Plugin Manager</h3>
                    <div class="manager-body setting-page-manager">
                    </div>
                </div>
            </div>
        </div>
        <div class="byte-builder-content">
            <div wire:ignore wire:grapesjs wire:grapesjs.options='@json($options)'></div>
        </div>
        <div class="byte-builder-setting">
            <div class="byte-builder-setting__component" x-data="{ tabIndex: 0 }">
                <div class="byte-builder-setting__component--tabs">
                    <div class="byte-builder-setting__component--tab" :class="tabIndex == 0 ? 'active' : ''"
                        @click="tabIndex=0">
                        Style
                    </div>
                    <div class="byte-builder-setting__component--tab" :class="tabIndex == 1 ? 'active' : ''"
                        @click="tabIndex=1">
                        Selector
                    </div>
                    <div class="byte-builder-setting__component--tab" :class="tabIndex ==  2 ? 'active' : ''"
                        @click="tabIndex=2">
                        Setting
                    </div>
                    <div class="byte-builder-setting__component--tab" :class="tabIndex == 3 ? 'active' : ''"
                        @click="tabIndex=3">
                        Layer
                    </div>
                </div>
                <div class="byte-builder-setting__component--content">
                    <div x-show="tabIndex==0" class="style-manager manager-container">
                    </div>
                    <div x-show="tabIndex==1" class="selector-manager manager-container">
                    </div>  
                    <div x-show="tabIndex==2" class="trait-manager manager-container">
                    </div>
                    <div x-show="tabIndex==3" class="layer-manager manager-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
