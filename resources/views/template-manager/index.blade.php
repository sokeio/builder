<div class="modal-body p-0" x-data='{
    async getTemplateHtml(){
    return "demo";
}
}'>
    <div class="p-2">
        <div class="row">
            <div class="col">
            </div>
            <div class="col-auto">
                <input class=" form-control" />
            </div>
        </div>
    </div>
    <div class="border-top-wide">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
            </li>
        </ul>
        <div style="min-height: 400px">
        </div>
    </div>
    <div class=" p-2 text-center  border-top-wide">
        <button class=" btn btn-primary rounded-1" @click="{{ $callbackEvent }}(await getTemplateHtml())">Choose
            Template</button>
    </div>
</div>
