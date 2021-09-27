<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/admin_default/css/product-intro.css"/>

<!---------------------------------------------------->
<!-- BEGIN: error -->
<div class="alert alert-danger" role="alert">{ERROR}</div>
<!-- END: error -->
<!-- BEGIN: success -->
<div class="alert alert-success" role="alert">{SUCCESS}</div>
<!-- END: success -->

<div class="well">
    <!-- BEGIN: product_name -->
    <table class="table">
        <caption><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> {LANG.prod_slider_title} <em>{PROD.name}</em></caption>
    </table>
    <!-- END: product_name -->

    <form enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="POST">
        <div class="row">
            <!-- file upload -->
            <div class="col-sm-12 col-md-13">
                <input class="w400 form-control pull-left" type="text" name="path" id="SLIDER" value="{FORM_DATA.feature_SLIDER_path}" readonly/>
                <input type="hidden" name="name" id="SLIDERalt"/>
                <input type="button" value="Browse server" name="selectimg" class="btn btn-info" style="margin-left: 5px;"/>
            </div>

            <!-- nổi bật -->
            <div class="col-sm-12 col-md-4 pdt-checkbox">
                <label for="" class="control-label">{LANG.highlight} <sup class="required">(*)</label>
                <label class="switch">
                    <input type="checkbox" name="check_highlight" {FORM_DATA.highlight}/>
                    <span class="slider round"></span>
                </label>
            </div>

            <!-- hiển thị -->
            <div class="col-sm-12 col-md-4 pdt-checkbox">
                <label for="" class="control-label">{LANG.active} <sup class="required">(*)</label>
                <label class="switch">
                    <input type="checkbox" name="check_active" {FORM_DATA.active}/>
                    <span class="slider round"></span>
                </label>
            </div>

            <!-- submit -->
            <div class="col-xs-12 col-md-3">
                <button name="form_submit" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; {LANG.submit}</button>
            </div>
        </div>

        <!-- note -->
        <!-- <label><em>Từ khóa tìm kiếm không lớn hơn 64 ký tự, không dùng các mã html</em></label> -->
    </form>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <caption><em class="fa fa-file-text-o">&nbsp;</em>Danh sách ảnh</caption>
        <thead>
            <tr>
                <th class="text-center">{LANG.stt}</th>
                <th class="text-center">{LANG.SLIDER}</th>
                <th>{LANG.slider_name}</th>
                <th class="text-center">{LANG.highlight}</th>
                <th class="text-center">{LANG.active}</th>
                <th class="text-center">{LANG.created_at} / {LANG.updated_at}</th>
                <th class="text-center">{LANG.action}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <!-- STT -->
                <td class="text-center align-middle">
                    <select name="weight" class="form-control weight_{SLIDER.id}" onchange="change_weight({SLIDER.id});">
                        <!-- BEGIN: weight -->
                        <option value="{STT}" {STT_SELECTED}>{STT}</option>
                        <!-- END: weight -->
                    </select>
                </td>

                 <!-- slider image -->
                <td class="w100 align-midlle">
                    <img src="{SLIDER.path}" alt="{SLIDER.name}" title="{LANG.zoom_in}" onclick="zoomSLIDER('{SLIDER.path}', '{SLIDER.name}', '{LANG.zoom_out}');" style="width:100%;cursor: pointer;">
                </td>

                 <!-- name -->
                <td class="w400">{SLIDER.name}</td>

                 <!-- highight -->
                <td class="text-center align-middle">
                    <label class="switch">
                        <input type="checkbox" class="highlight_input_{SLIDER.id}" {SLIDER.highlight} onchange="change_highlight({SLIDER.id});"/>
                        <span class="slider round"></span>
                    </label>
                </td>

                 <!-- active -->
                <td class="text-center align-middle">
                    <label class="switch">
                        <input type="checkbox" class="active_input_{SLIDER.id}" {SLIDER.active} onchange="change_active({SLIDER.id});"/>
                        <span class="slider round"></span>
                    </label>
                </td>

                 <!-- ngày tạo -->
                <td class="text-center align-middle">{SLIDER.created_at} <br/> {SLIDER.updated_at}</td>
                
                 <!-- thao tác -->
                <td class="text-center align-middle">
                    <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="notifyAlert('{SLIDER.id}');">
                        <i class="fa fa-trash" aria-hidden="true"></i> {LANG.remove}
                    </a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <!-- phân trang -->
    {PAGINATE}

    <!-- BEGIN: notify -->
    {NOTIFY_EMPTY}
    <!-- END: notify -->
</div>

<!---------[ js ]------------------------------------------->
<script src="{NV_BASE_SITEURL}themes/admin_default/js/sweetalert2.js"></script>
<script src="{NV_BASE_SITEURL}themes/admin_default/js/product-intro.js"></script>
<script type="text/javascript">
    let sPageURL = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&nocache=' + new Date().getTime() + '&page={PAGE}';

    $(document).ready(function() {
        // upload file:
        $("input[name=selectimg]").click(function() {
            var area = "SLIDER"; //id của thẻ input lưu đường dẫn file
            var alt = "SLIDERalt"; //id của thẻ input lưu tiêu đề file
            var type = "SLIDER"; // kiểu định dạng cho phép upload
            var currentpath = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/{PROD_ID}'; // show current folder
            var path = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/{PROD_ID}'; //save SLIDER folder

            nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&alt=" + alt + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    
            return false;
        });
    });

    // thay đổi thứ tự:
    function change_weight(slider_id) {
            let new_weight = $('.weight_' + slider_id).val();
            window.location.replace(sPageURL + '&change_weight=true&id=' + slider_id + '&new_weight=' + new_weight);
    }

    // thay đổi highlight:
    function change_highlight(slider_id) {
        let new_status = 0;
        if ($('.highlight_input_' + slider_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(sPageURL + '&change_highlight=true&id=' + slider_id + '&new_status=' + new_status);
    }

    // thay đổi active:
    function change_active(slider_id) {
        let new_status = 0;
        if ($('.active_input_' + slider_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(sPageURL + '&change_active=true&id=' + slider_id + '&new_status=' + new_status);
    }

    // thông báo xoá:
    function notifyAlert(slider_id) {
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
                Swal.fire(
                    '{LANG.sweet_fire_title_success}',
                    '{LANG.sweet_fire_text_del}',
                    'success'
                ).then((result) => {
                    // xử lí:
                    window.location.replace(sPageURL + '&action_del=true&id=' + slider_id + '&checksess=' + slider_id + '{NV_CHECK_SESSION}');
                })
            }
        })
    }

</script>
<!-- END: main -->

