<!-- BEGIN: main -->
<div class="news_column panel panel-default" itemtype="http://schema.org/NewsArticle" itemscope>
    <div class="panel-body">
        <h1 class="title margin-bottom-lg" itemprop="headline">{DETAIL.name}</h1>
        <div class="hidden hide d-none" itemprop="author" itemtype="http://schema.org/Person" itemscope>
            <span itemprop="name">{SCHEMA_AUTHOR}</span>
        </div>
        <span class="hidden hide d-none" itemprop="datePublished">{SCHEMA_DATEPUBLISHED}</span>
        <span class="hidden hide d-none" itemprop="dateModified">{SCHEMA_DATEPUBLISHED}</span>
        <div class="row margin-bottom-lg">
            <div class="col-md-12">
                <span class="h5">{DETAIL.publtime}</span>
            </div>
            <div class="col-md-12">
                <ul class="list-inline text-right">
                    <li><a class="dimgray" rel="nofollow" title="{LANG.sendmail}" href="javascript:void(0);" ><em class="fa fa-envelope fa-lg">&nbsp;</em></a></li>
                    <li><a class="dimgray" rel="nofollow" title="{LANG.print}" href="javascript: void(0)" ><em class="fa fa-print fa-lg">&nbsp;</em></a></li>
                    <li><a class="dimgray" rel="nofollow" title="{LANG.savefile}" href="javascript: void(0)"><em class="fa fa-save fa-lg">&nbsp;</em></a></li>
                </ul>
            </div>
        </div>

        <div class="clearfix">
             <div class="hometext m-bottom" itemprop="description">{DETAIL.description}</div>
            <figure class="article center">
                <img alt="{DETAIL.name}" src="{DETAIL.highlight.path}" width="300px" class="img-thumbnail"/>
                <figcaption>ảnh album</figcaption>
            </figure>
        </div>

        <div id="news-bodyhtml" class="bodytext margin-bottom-lg">
            {DETAIL.content}
        </div>
    </div>
</div>

<div class="news_column panel panel-default">
    <div class="panel-body">
        <div class="h5">
            <em class="fa fa-tags">&nbsp;</em><strong>{LANG.tags}: </strong>
            <a title="album đẹp" href="#">
                <em>album đẹp</em>
            </a>
        </div>
    </div>
</div>
<!-- END: main -->
