<!-- BEGIN: main -->
<div class="news_column panel panel-default" itemtype="http://schema.org/NewsArticle" itemscope>
    <div class="panel-body">
        <!-- BEGIN: detail -->
        <h1 class="title margin-bottom-lg" itemprop="headline">{DETAIL.title}</h1>
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
                <img alt="{DETAIL.title}" src="{DETAIL.feature_image_path}" width="300px" class="img-thumbnail"/>
                <figcaption>{DETAIL.title}</figcaption>
            </figure>
        </div>

        <div id="news-bodyhtml" class="bodytext margin-bottom-lg">
            {DETAIL.content}
        </div>
        <!-- END: detail -->
        <div class="clearfix"></div>
    
        <!-- show kho ảnh ------------------>
        <div class="col-xs-12">
            <p class="title-image"><i class="fa fa-picture-o" aria-hidden="true"></i> {LANG.title_image}</p>
        </div>
        <div class="clearfix"></div>
        <!-- BEGIN: loop_image -->
        <div class="responsive">
            <div class="gallery">
                <a target="_blank" href="{IMAGE.path}">
                    <img src="{IMAGE.path}" alt="{IMAGE.name}" width="600">
                </a>
            </div>
        </div>
        <!-- END: loop_image -->

        <div class="clearfix"></div>
        <hr>
        <div class="margin-bottom-lg">
            <p class="h5 text-right">
                <strong>Nguồn: </strong>VINADES.,JSC
            </p>
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

<!------------------------------------------------>
<style>
    .title-image {
        font-size: 14px;
        font-weight: bold;
    }

    div.gallery {
      border: 1px solid #ccc;
    }
    
    div.gallery:hover {
      border: 1px solid #777;
    }
    
    div.gallery img {
      width: 100%;
      height: auto;
    }
    
    .responsive {
      padding: 0 6px;
      float: left;
      width: 24.99999%;
    }
    
    @media only screen and (max-width: 700px) {
      .responsive {
        width: 49.99999%;
        margin: 6px 0;
      }
    }
    
    @media only screen and (max-width: 500px) {
      .responsive {
        width: 100%;
      }
    }
</style>
<!-- END: main -->
