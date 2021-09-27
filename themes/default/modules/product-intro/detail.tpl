<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/slick.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/slick-theme.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/select2.min.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/product-intro.css"/>

<!-------------------------------------------->
<div class="news_column panel panel-default" itemtype="http://schema.org/NewsArticle" itemscope>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-24 col-md-12 margin-bottom-lg">
                <div class="slider-for margin-bottom text-center">
                    <!-- BEGIN: loop_image -->
                    <img src="{IMAGE.path}" width="" class="img-thumbnail"/>
                    <!-- END: loop_image -->
                </div>
                <div class="slider-nav">
                    <!-- BEGIN: loop_image_nw -->
                    <img src="{IMAGE.path}"/>
                    <!-- END: loop_image_nw -->
                </div>
            </div>
    
            <div class="col-sm-24 col-md-12 padding-left margin-bottom-lg">
                <h2>{DETAIL.name}</h2>
                <div class="d_price"><i class="fa fa-caret-right" aria-hidden="true"></i> {DETAIL.price} {LANG.currency.0}</div>
                <div class="margin-top margin-bottom">{DETAIL.description}</div>
                <div class="btn-act">
                    <a href="#" class="btn-a">
                        <div class="d_contact"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; {LANG.contact_now}</div>
                    </a>
                    <a href="#" class="btn-a">
                        <div class="d_showmore">{LANG.show_more}</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- nội dung chi tiết -->
    <div class="row">
        <div class="col-sm-24 col-md-24 margin-bottom-lg">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab-main">{LANG.contents}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab-evaluate">{LANG.evaluate} (0)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab-instruct">{LANG.instruct}</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="tab-main" class="panel-body tab-pane"><br>
                    {DETAIL.content} <br>
                    <!-- BEGIN: loop_slider -->
                    <img src="{SLIDER.path}" class="img-thumbnail margin-top-lg" alt="{DETAIL.name}">
                    <!-- END: loop_slider -->
                </div>
                <div id="tab-evaluate" class="panel-body tab-pane fade"><br>
                    <p>{LANG.evaluate_content}</p>
                </div>
                <div id="tab-instruct" class="panel-body tab-pane fade"><br>
                    <p>{LANG.instruct_content}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="margin-bottom-lg">
        <p class="h5 text-right">
            <span class="h5" style="padding-right: 10px;">{DETAIL.publtime}</span>
        </p>
    </div>
</div>

<!-- sản phẩm liên quan ----------------->
<div class="panel-heading">
    <ul class="list-inline" style="margin: 0">
        <li><h4><i class="fa fa-book" aria-hidden="true"></i> <span>{LANG.relate_prod}</span></h4></li>
    </ul>
</div>
<div class="relate-products">
    <!-- BEGIN: loop_relate_prod -->
    <div class="col-sm-12 col-md-8">
        <div class="box-prod">
            <a href="{RE_PROD.url_detail}">
                <img class="b-img" src="{RE_PROD.feature_image_path}" alt="{RE_PROD.name}"/>
            </a>
            <div class="content-prod">
                <a href="{RE_PROD.feature_image_path}">
                    <div class="b-name text-center">{RE_PROD.name}</div>
                </a>
                <div class="b-price text-center">{RE_PROD.price} {LANG.currency.0}</div>
            </div>
        </div>
    </div>
    <!-- END: loop_relate_prod -->
</div>

<!---------[ js ]------------------------------------------->
<script src="{NV_BASE_SITEURL}themes/default/js/slick.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/default/js/select2.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/default/js/product-intro.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // chuyển tab:
    $(".active").tab('show');
    $(".nav-tabs a").click(function() {
        $(this).tab('show');
    });

    // show ảnh sp:
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        autoplay: true,
        focusOnSelect: true,
        autoplaySpeed: 2000,
        dots: true,
        centerMode: true,
        focusOnSelect: true,
    });

    // sản phẩm liên quan:
    $('.relate-products').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        prevArrow:"<img class='a-left control-c prev slick-prev' src='{NV_BASE_SITEURL}themes/default/images/{MODULE_NAME}/arrow-left.png'>",
        nextArrow:"<img class='a-right control-c next slick-next' src='{NV_BASE_SITEURL}themes/default/images/{MODULE_NAME}/arrow-right.png'>"
    });
});
</script>
<!-- END: main -->
