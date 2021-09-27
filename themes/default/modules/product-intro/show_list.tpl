<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/slick.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/slick-theme.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/select2.min.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/product-intro.css"/>

<!-------------------------------------------->
<div class="col-sm-24 col-md-24">
    <!-- BEGIN: check_records -->
    <!-- Tất cả sản phẩm ----------------->
    <div class="panel-heading">
        <ul class="list-inline" style="margin: 0">
            <li><h4><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>{LANG.all_prod}</span></h4></li>
        </ul>
    </div>

    <!-- tìm kiếm ---------->
    <div class="well">
        <form action="{NV_BASE_SITEURL}index.php?" method="GET">
            <!-- áp dụng chup pt GET -->
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <input type="hidden" name="search_act" value="true" />
    
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                        <input class="form-control" type="text" value="{SEARCH_DATA.text_search}" maxlength="64" name="text_search" placeholder="Từ khóa tìm kiếm">
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <select class="select2 form-control" name="cate_id">
                            <!-- BEGIN: cate_option -->
                            {CATE_OPTION}
                            <!-- END: cate_option -->
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="{LANG.search}">
                    </div>
                </div>
            </div>
        </form>
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
    <!-- phân trang -->
    {PAGINATE}

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
    <!-- END: check_records -->

    <!-- BEGIN: notify -->
    {NOTIFY_EMPTY}
    <!-- END: notify -->
</div>

<!---------[ js ]------------------------------------------->
<script src="{NV_BASE_SITEURL}themes/default/js/slick.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/default/js/select2.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/default/js/product-intro.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".select2").select2();

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
