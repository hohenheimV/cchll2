<div class="form-group">
    {{ Form::label('title', 'Title') }}
    {{ Form::text('title',null,['placeholder'=>'Sila masukkan Title','class' => 'form-control '.Html::isInvalid($errors,'title')]) }}
    {!! Html::hasError($errors,'title') !!}
</div>
<div class="form-group">
    {{ Form::label('page_id', 'Page') }}
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                {{ Form::radio('type', 'pages', $menu && $menu->type == 'pages' ? true : false) }}
            </div>
        </div>
        {{ Form::select('page_id', $pages, null, ['placeholder' => 'Pilihan','class' => 'form-control']) }}
    </div>
    {!! Html::hasError($errors,'page_id') !!}
</div>
<div class="form-group">
    {{ Form::label('article_id', 'Article') }}
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                {{ Form::radio('type', 'articles',$menu && $menu->type == 'articles' ? true : false) }}
            </div>
        </div>
        {{ Form::select('article_id', $articles, null, ['placeholder' => 'Pilihan','class' => 'form-control']) }}
    </div>
    {!! Html::hasError($errors,'article_id') !!}
</div>
<div class="form-group">
    {{ Form::label('category_id', 'Categories') }}
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                {{ Form::radio('type', 'category',$menu && $menu->type == 'category' ? true : false) }}
            </div>
        </div>
        {{ Form::select('category_id', $categories, null, ['placeholder' => 'Pilihan','class' => 'form-control']) }}
    </div>
    {!! Html::hasError($errors,'article_id') !!}
</div>
<div class="form-group">
    {{ Form::label('url', 'Custom Links') }}
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                {{ Form::radio('type', 'url',$menu && $menu->type == 'url' ? true : false) }}
            </div>
        </div>
        {{ Form::text('url',null,['placeholder'=>'Sila masukkan URL','class' => 'form-control '.Html::isInvalid($errors,'url')]) }}
    </div>
    {!! Html::hasError($errors,'url') !!}
</div>
<div class="form-group">
    {{ Form::label('target', 'Target') }}
    {{ Form::select('target', ['_self' => '_self', '_blank' => '_blank'], null, ['placeholder' => '--Pilihan--','class' => 'form-control '.Html::isInvalid($errors,'target')]) }}
    {!! Html::hasError($errors,'target') !!}
</div>
