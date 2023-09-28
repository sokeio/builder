<div class="modal-body p-0"
    x-data='{
        templateCurrent:null,
        catagoryCurrent:"",
        searchText:"",
        async getTemplateHtml(){
            return this.templateCurrent?.content??"";
        },templates:@json($templates),
        getTemplates(){
            let self=this;
            return this.templates.filter((item, index) => {
                return (self.catagoryCurrent==""||self.catagoryCurrent==item.category)  && (
                    self.searchText==""||
                    item.category?.indexOf(self.searchText)>-1||
                    item.author?.indexOf(self.searchText)>-1||
                    item.topic?.indexOf(self.searchText)>-1||
                    item.email?.indexOf(self.searchText)>-1||
                    item.description?.indexOf(self.searchText)>-1||
                    item.template_name?.indexOf(self.searchText)>-1

                );
              });
        },
        chooseTemplate(item){
            if(this.templateCurrent==item){
                this.templateCurrent=null;
            }else{
                this.templateCurrent=item;
            }
        },
        getCatagorys(){
            return this.templates.map((item)=>{
                return item.category;
            }).filter((value, index, self) => {
                return self.indexOf(value) === index;
              });
        }
}'>
    <div class="p-2">
        <div class="row">
            <div class="col">
            </div>
            <div class="col-auto">
                <input class=" form-control" x-model="searchText" />
            </div>
        </div>
    </div>
    <div class="border-top-wide">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" :class="catagoryCurrent == '' ? 'active' : ''"
                    @click="catagoryCurrent='';templateCurrent=null;" aria-current="page" href="#">All</a>
            </li>
            <template x-for="item in getCatagorys()">
                <li class="nav-item">
                    <a class="nav-link" :class="catagoryCurrent == item ? 'active' : ''"
                        @click="catagoryCurrent=item;templateCurrent=null;" href="#" x-text="item">Link</a>
                </li>
            </template>
        </ul>
        <div style="min-height: 400px">
            <div class="row g-1">
                <template x-for="item in getTemplates()">
                    <div class="col-3  p-1">
                        <div class="border border-pink rounded-1" :class="item == templateCurrent ? 'border-2' : ''"
                            @click="chooseTemplate(item)">
                            <template x-if="item.thumbnail">
                                <div :style='"background-repeat: no-repeat; background-size: cover;height: 180px;background-position: center;width: 99%; background-image: url(" +
                                item.thumbnail + "); "'
                                    class="template-preview"></div>
                            </template>
                            <template  x-if="item.thumbnail==''">
                                <svg xmlns="http://www.w3.org/2000/svg" class="template-preview" viewBox="0 0 1300 1100"
                                    width="99%" height="180">
                                    <foreignObject width="100%" height="100%" style="pointer-events:none">
                                        <div xmlns="http://www.w3.org/1999/xhtml" x-html="item.content">
                                        </div>
                                    </foreignObject>
                                </svg>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <div class=" p-2 text-center  border-top-wide">
        <button :disabled="!templateCurrent" class=" btn btn-primary rounded-1"
            @click="{{ $callbackEvent }}(await getTemplateHtml())">Choose
            Template</button>
    </div>
</div>
