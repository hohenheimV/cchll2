<div class="form-group">
    {{ Form::label('title', 'Tajuk') }}
    {{ Form::text('title',null,['placeholder'=>'Sila Masukkan Tajuk','class' => 'form-control '.Html::isInvalid($errors,'title')]) }}
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
    {{ Form::label('article_id', 'Artikel') }}
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
    {{ Form::label('category_id', 'Kategori') }}
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
    {{ Form::label('url', 'URL Pautan') }}
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                {{ Form::radio('type', 'url',$menu && $menu->type == 'url' ? true : false) }}
            </div>
        </div>
        {{ Form::text('url',null,['placeholder'=>'Sila Masukkan URL Pautan','class' => 'form-control '.Html::isInvalid($errors,'url')]) }}
    </div>
    {!! Html::hasError($errors,'url') !!}
</div>
<div class="form-group">
    {{ Form::label('target', 'Target') }}
    {{ Form::select('target', ['_self' => 'Open in Same Tab', '_blank' => 'Open in New Tab'], null, ['placeholder' => '--Pilihan--','class' => 'form-control '.Html::isInvalid($errors,'target')]) }}
    {!! Html::hasError($errors,'target') !!}
</div>
