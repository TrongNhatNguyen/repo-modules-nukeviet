<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/admin_default/css/select2.min.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/admin_default/css/product-intro.css"/>

<!---------------------------------------------------->
<div class="well">
    <form action="{NV_BASE_ADMINURL}index.php?" method="GET">
        <!-- áp dụng chup pt GET -->
        <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
        <input type="hidden" name="search_act" value="true" />

        <div class="row">
            <div class="col-xs-12 col-md-10">
                <div class="form-group">
                    <input class="form-control" type="text" value="{SEARCH_DATA.text_search}" maxlength="64" name="text_search" placeholder="Từ khóa tìm kiếm">
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <select class="select2" style="width: 100%;" name="cate_id">
                        <!-- BEGIN: cate_option -->
                        {CATE_OPTION}
                        <!-- END: cate_option -->
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="form-group">
                    <select class="select2-disable-search form-control" name="status">
                        <!-- BEGIN: status_option -->
                        {STATUS_OPTION}
                        <!-- END: status_option -->
                    </select>
                </div>
            </div><div class="col-xs-12 col-md-2">
                <div class="form-group">
                    <select class="select2-disable-search form-control" name="perpage">
                        <!-- BEGIN: perpage_option -->
                        {PERPAGE_OPTION}
                        <!-- END: perpage_option -->
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{LANG.search}">
                </div>
            </div>
        </div>
        <label><em>Từ khóa tìm kiếm không ít hơn 2 ký tự, không lớn hơn 64 ký tự, không dùng các mã html</em></label>
    </form>
</div>
<div class="table-responsive">
    <form action="{PROD.url_action}" method="POST" id="tableProduct">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">
                        <input type="checkbox" value="yes" id="checkAll">
                    </th>
                    <th>{LANG.prod_name}</th>
                    <th class="text-center">{LANG.image}</th>
                    <th>{LANG.price}</th>
                    <th>{LANG.description}</th>
                    <th class="text-center">{LANG.active}</th>
                    <th class="text-center">{LANG.created_at} / {LANG.updated_at}</th>
                    <th class="text-center">{LANG.action}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <!-- checkbox -->
                    <td class="text-center">
                        <input type="checkbox" name="check_list[]" value="{PROD.id}" class="checkItem">
                    </td>

                    <!-- tiêu đề -->
                    <td class="w150">
                        <b>{PROD.name}</b>
                    </td>

                    <!-- ảnh đại diện -->
                    <td class="w110 align-midlle">
                        <img src="{PROD.feature_image_path}" alt="{PROD.name}" title="{LANG.zoom_in}" onclick="zoomImage('{PROD.feature_image_path}', '{PROD.name}', '{LANG.zoom_out}');" style="width:100%;cursor: pointer;">
                    </td>

                    <!-- giá -->
                    <td>{PROD.price} VNĐ</td>

                    <!-- mô tả -->
                    <td class="desc w250" data-status="collapse" data-content="{PROD.description}">
                        <div class="text-collapse w250">{PROD.description}</div>
                    </td>

                    <!-- hiển thị -->
                    <td class="text-center align-middle">
                        <label class="switch">
                            <input type="checkbox" class="active_input_{PROD.id}" {PROD.active} onchange="change_active({PROD.id});"/>
                            <span class="slider round"></span>
                        </label>
                    </td>

                    <!-- ngày tạo -->
                    <td class="text-center align-middle">{PROD.created_at} <br/> {PROD.updated_at}</td>

                    <!-- thao tác -->
                    <td class="text-center align-middle">
                        <div class="btn-group">
                            <a href="{PROD.url_edit}" class="btn btn-sm btn btn-primary text-white" data-toggle="tooltip" data-original-title="{LANG.edit_prod_title}">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                {LANG.edit}
                            </a>
                            <button type="button" class="btn btn-sm btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span><span class="sr-only">{LANG.edit}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{PROD.url_image_update}">{LANG.image_list}</a></li>
                                <li><a href="{PROD.url_slider_update}">{LANG.slider_list}</a></li>
                            </ul>
                        </div>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="notifyAlert('{PROD.id}');">
                            <i class="fa fa-trash" aria-hidden="true"></i> {LANG.remove}
                        </a>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
            <!-- BEGIN: multiple_action -->
            <tfoot>
                <tr class="text-left">
                    <td colspan="12">
                        <select class="select2-disable-search w200" id="multipleAction" name="multiple_action">
                            {MULTIPLE_OPTION}
                        </select>
                        <input type="submit" class="btn btn-primary" value="{LANG.perform}">
                    </td>
                </tr>
            </tfoot>
            <!-- END: multiple_action -->
        </table>
    </form>
    <!-- phân trang -->
    {PAGINATE}

    <!-- BEGIN: notify -->
    {NOTIFY_EMPTY}
    <!-- END: notify -->
</div>

<!---------[ js ]------------------------------------------->
<script src="{NV_BASE_SITEURL}themes/admin_default/js/sweetalert2.js"></script>
<script src="{NV_BASE_SITEURL}themes/admin_default/js/select2.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/admin_default/js/product-intro.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2();
        $(".select2-disable-search").select2({
            minimumResultsForSearch: Infinity
        });

        // mở rộng, thu gọn mô tả:
        $('body').on('click', '.desc', function (event) {
            event.preventDefault();
            var status = $(this).attr('data-status');
            var content = $(this).attr('data-content');
            $(this).animate({'opacity': 0.5}, 400, function() {
                if (status == 'collapse') {
                    $(this).html('<div>' + content +'</div>').animate({'opacity': 1}, 400);
                    $(this).attr('data-status', 'expand');
                } else {
                    $(this).html('<div class="text-collapse w250">' + content +'</div>').animate({'opacity': 1}, 400);
                    $(this).attr('data-status', 'collapse');
                }
            });
        })

        // checkbox all:
        $('body').on('click', '#checkAll', function (event) {    
            $(':checkbox.checkItem').prop('checked', this.checked);
        });
    
        // multiple action:
        $('body').on('submit', '#tableProduct', function (event) {
            event.preventDefault();

            // kiểm tra xem có check chưa
            var vals = "";
            $.each($("input[name='check_list[]']:checked"), function() {  
                vals += "~"+$(this).val();  
            });
            if (vals == "") {
                Swal.fire({
                    text: '{LANG.sweet_fire_checkbox_text}',
                })
                return;
            }

            // check thì tiếp tục
            var act = $('#multipleAction').val();
            if (act != 'del') {
                $.ajax({
                    url: getSearchParams(),
                    type: 'post',
                    dataType: 'text',
                    data: $(this).serialize(),
                }).done(function (error) {
                    if (error == "") {
                        Swal.fire(
                            '{LANG.sweet_fire_title_success}',
                            '{LANG.sweet_fire_text_upd}',
                            'success'
                        ).then((result) => {
                            window.location.replace(getSearchParams());
                        })
                    } else {
                        Swal.fire(
                            '{LANG.sweet_fire_title_error}',
                            error,
                            'warning'
                        )
                    }
                });
            } else {
                var error;
                Swal.fire({
                    title: '{LANG.sweet_alert_title}',
                    text: '{LANG.sweet_alert_text}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff8311',
                    cancelButtonColor: '#888888',
                    confirmButtonText: '{LANG.sweet_alert_confirm_btn}',
                    cancelButtonText: '{LANG.sweet_alert_cancel_btn}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: getSearchParams(),
                            type: 'post',
                            dataType: 'text',
                            data: $(this).serialize(),
                        }).done(function (error) {
                            if (error == "") {
                                Swal.fire(
                                    '{LANG.sweet_fire_title_success}',
                                    '{LANG.sweet_fire_text_del}',
                                    'success'
                                ).then((result) => {
                                    window.location.replace(getSearchParams());
                                })
                            } else {
                                Swal.fire(
                                    '{LANG.sweet_fire_title_error}',
                                    error,
                                    'warning'
                                )
                            }
                        });
                    }
                })
            }
        });
    });


    // thay đổi active:
    function change_active(prod_id) {
        var new_status = 0;
        if ($('.active_input_' + prod_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(getSearchParams()
                                + '&change_active=true&id=' + prod_id
                                + '&new_status=' + new_status);
    }

    // thông báo xoá:
    function notifyAlert(prod_id) {
        var error;
        Swal.fire({
            title: '{LANG.sweet_alert_title}',
            text: '{LANG.sweet_alert_text}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff8311',
            cancelButtonColor: '#888888',
            confirmButtonText: '{LANG.sweet_alert_confirm_btn}',
            cancelButtonText: '{LANG.sweet_alert_cancel_btn}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                  + '={OP}&nocache=' + new Date().getTime()
                                  + '&action_del=true&id=' + prod_id
                                  + '&checksess=' + prod_id + '{NV_CHECK_SESSION}',
                    function (error) {
                        if (error == "") {
                            Swal.fire(
                                '{LANG.sweet_fire_title_success}',
                                '{LANG.sweet_fire_text_del}',
                                'success'
                            ).then((result) => {
                                window.location.reload();
                            })
                        } else {
                            Swal.fire(
                                '{LANG.sweet_fire_title_error}',
                                error,
                                'warning'
                            )
                        }
                    }
                );
            }
        })
    }

    // lấy params search từ url hiện tại:
    function getSearchParams() {
        var arr_name_search = ['search_act', 'text_search', 'cate_id', 'status', 'perpage'];

        let re_params = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&page={PAGE}&nocache=' + new Date().getTime();
        let searchParams = new URLSearchParams(window.location.search);
        let i;

        for (i = 0; i < arr_name_search.length; i++) {
            $key = arr_name_search[i];
            if (searchParams.has($key) == true) {
                re_params += '&' + $key + '=' + searchParams.get($key);
            }
        }
        return re_params;
    };
</script>
<!-- END: main -->

