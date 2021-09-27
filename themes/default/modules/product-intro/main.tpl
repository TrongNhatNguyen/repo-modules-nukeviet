<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/slick.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/slick-theme.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/product-intro.css"/>

<!-------------------------------------------->
<div class="col-sm-24 col-md-24">
    <!-- BEGIN: check_records -->
    <!-- sản phẩm nổi bật ----------------->
    <div class="panel-heading">
        <ul class="list-inline" style="margin: 0">
            <li><h4><i class="fa fa-fire" aria-hidden="true"></i> <span>{LANG.feature_prod}</span></h4></li>
        </ul>
    </div>
    <div class="random-products">
        <!-- BEGIN: loop_random_prod -->
        <div class="box-bg">
            <img class="bg-slider" src="{R_PROD.slider.path}" alt="R_PROD.name"/>
            <div class="content">
                <a class="image-prod" href="{R_PROD.url_detail}" title="{R_PROD.name}">
                    <img alt="{R_PROD.name}" src="{R_PROD.feature_image_path}" width="150" class="img-thumbnail pull-left imghome"/>
                </a>
                <div class="info-prod">
                    <div class="name-prod">
                        <a href="{R_PROD.url_detail}">{R_PROD.name}</a>
                    </div>
                    <div class="text-muted">
                        <ul class="list-unstyled list-inline">
                            <li>{R_PROD.price} VNĐ</li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END: loop_random_prod -->
    </div>

    <!-- sản phẩm mới nhất ----------------->
    <div class="panel-heading">
        <ul class="list-inline" style="margin: 0">
            <li><h4><i class="fa fa-plus-square" aria-hidden="true"></i> <span>{LANG.new_prod}</span></h4></li>
        </ul>
    </div>
    <div class="new-products">
        <!-- BEGIN: loop_new_prod -->
        <div class="col-sm-12 col-md-8">
            <div class="box-prod">
                <a href="{N_PROD.url_detail}">
                    <img class="b-img" src="{N_PROD.feature_image_path}" alt="{N_PROD.name}"/>
                </a>
                <div class="content-prod">
                    <a href="{N_PROD.feature_image_path}">
                        <div class="b-name text-center">{N_PROD.name}</div>
                    </a>
                    <div class="b-price text-center">{N_PROD.price} {LANG.currency.0}</div>
                </div>
            </div>
        </div>
        <!-- END: loop_new_prod -->
    </div>

    <!-- Tất cả sản phẩm ----------------->
    <div class="panel-heading">
        <ul class="list-inline" style="margin: 0">
            <li><h4><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>{LANG.all_prod}</span></h4></li>
            <a href="{URL_REDIRECT.show_list}" class="dimgray pull-right hidden-xs">
                Xem Thêm &nbsp; <em class="fa fa-sign-out"></em>
            </a>
        </ul>
    </div>
    <div class="row">
        <!-- BEGIN: loop -->
        <div class="col-sm-12 col-md-8">
            <div class="box-prod">
                <a href="{PROD.url_detail}">
                    <img class="b-img" src="{PROD.feature_image_path}" alt="{PROD.name}"/>
                </a>
                <div class="content-prod">
                    <a href="{PROD.feature_image_path}">
                        <div class="b-name text-center">{PROD.name}</div>
                    </a>
                    <div class="b-price text-center">{PROD.price} {LANG.currency.0}</div>
                </div>
            </div>
        </div>
        <!-- END: loop -->
    </div>
    <!-- END: check_isset_record -->

    <!-- BEGIN: notify -->
    {NOTIFY_EMPTY}
    <!-- END: notify -->
</div>

<!---------[ js ]------------------------------------------->
<script src="{NV_BASE_SITEURL}themes/default/js/slick.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/default/js/product-intro.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // sản phẩm nổi bật:
    $('.random-products').slick({
        dots: true,
        infinite: true,
        speed: 800,
        cssEase: 'linear',
        adaptiveHeight: true,
        autoplay: true,
        slidesToScroll: 1,
        centerMode: true,
        focusOnSelect: true,
        autoplaySpeed: 2500
    });

    // sản phẩm mới:
    $('.new-products').slick({
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
