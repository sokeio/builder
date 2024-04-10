<div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <a class="btn btn-primary" href="{{ route('admin.builder-template.edit', ['dataId' => $template->id]) }}">
            Back
        </a>
    </div>
    {!! $template->content !!}
</div>
