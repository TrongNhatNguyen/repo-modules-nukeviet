<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-danger" role="alert">{ERROR}</div>
<!-- END: error -->
<!-- BEGIN: success -->
<div class="alert alert-success" role="alert">{SUCCESS}</div>
<!-- END: success -->

<div class="well">
    <!-- BEGIN: album-title -->
    <table class="table">
        <caption><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> {LANG.album_image_title} <em>{ALBUM.title}</em></caption>
    </table>
    <!-- END: album-title -->

    <form enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="POST">
        <div class="row">
            <!-- file upload -->
            <div class="col-sm-12 col-md-13">
                <input class="w400 form-control pull-left" type="text" name="path" id="image" value="{FORM_DATA.feature_image_path}" readonly/>
                <input type="hidden" name="name" id="imagealt"/>
                <input type="button" value="Browse server" name="selectimg" class="btn btn-info" style="margin-left: 5px;"/>
            </div>

            <!-- nổi bật -->
            <div class="col-sm-12 col-md-4 pdt-6p">
                <label for="" class="control-label">{LANG.highlight} <sup class="required">(*)</label>
                <label class="switch">
                    <input type="checkbox" name="check_highlight" {FORM_DATA.highlight}/>
                    <span class="slider round"></span>
                </label>
            </div>

            <!-- hiển thị -->
            <div class="col-sm-12 col-md-3 pdt-6p">
                <label for="" class="control-label">{LANG.active} <sup class="required">(*)</label>
                <label class="switch">
                    <input type="checkbox" name="check_active" {FORM_DATA.active}/>
                    <span class="slider round"></span>
                </label>
            </div>

            <!-- submit -->
            <div class="col-xs-12 col-md-4">
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
                <th class="text-center">{LANG.image}</th>
                <th>{LANG.image_name}</th>
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
                    <select name="weight" class="form-control weight_{IMAGE.id}" onchange="change_weight({IMAGE.id});">
                        <!-- BEGIN: weight -->
                        <option value="{STT}" {STT_SELECTED}>{STT}</option>
                        <!-- END: weight -->
                    </select>
                </td>

                 <!-- image -->
                <td class="w100 align-midlle">
                    <img src="{IMAGE.path}" alt="{IMAGE.name}" title="{LANG.zoom_in}" onclick="showImage('{IMAGE.path}', '{IMAGE.name}');" style="width:100%;cursor: pointer;">
                </td>

                 <!-- name -->
                <td class="w400">{IMAGE.name}</td>

                 <!-- highight -->
                <td class="text-center align-middle">
                    <label class="switch">
                        <input type="checkbox" class="highlight_input_{IMAGE.id}" {IMAGE.highlight} onchange="change_highlight({IMAGE.id});"/>
                        <span class="slider round"></span>
                    </label>
                </td>

                 <!-- active -->
                <td class="text-center align-middle">
                    <label class="switch">
                        <input type="checkbox" class="active_input_{IMAGE.id}" {IMAGE.active} onchange="change_active({IMAGE.id});"/>
                        <span class="slider round"></span>
                    </label>
                </td>

                 <!-- ngày tạo -->
                <td class="text-center align-middle">{IMAGE.created_at} <br/> {IMAGE.updated_at}</td>
                
                 <!-- thao tác -->
                <td class="text-center align-middle">
                    <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="notifyAlert('{IMAGE.id}');">
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

<!---------[ css + js ]------------------------------------------->
<style>
    .pdt-6p {
        padding-top: 6px;
    }
    .w-image{
        max-width: 100px;
    }

    tr > td {
        vertical-align: middle !important;
    }

    .switch {
        position: relative;
        display: inline-block;
        top: -3px;
        left: 1px;
        width: 52px;
        height: 25px;
    }

    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 23px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 23px;
        width: 23px;
        left: 1px;
        bottom: 1px;
        border-radius: 50%;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #428bca;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #428bca;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .swal-wide{
        width:620px !important;
    }
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // upload file:
        $("input[name=selectimg]").click(function() {
            var area = "image"; //id của thẻ input lưu đường dẫn file
            var alt = "imagealt"; //id của thẻ input lưu tiêu đề file
            var type = "image"; // kiểu định dạng cho phép upload
            var currentpath = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/{ALBUM_ID}'; // show current folder
            var path = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/{ALBUM_ID}'; //save image folder

            nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&alt=" + alt + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    
            return false;
        });
    });

    // thay đổi thứ tự:
    function change_weight(image_id) {
            var new_weight = $('.weight_' + image_id).val();
            window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                                + '=image_list&nocache=' + new Date().getTime()
                                                + '&page=' + {PAGE}
                                                + '&change_weight=true&id=' + image_id
                                                + '&new_weight=' + new_weight);
    }

    // thay đổi highlight:
    function change_highlight(image_id) {
        var new_status = 0;
        if ($('.highlight_input_' + image_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=image_list&nocache=' + new Date().getTime()
                                            + '&page=' + {PAGE}
                                            + '&change_highlight=true&id=' + image_id
                                            + '&new_status=' + new_status);
    }

    // thay đổi active:
    function change_active(image_id) {
        var new_status = 0;
        if ($('.active_input_' + image_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=image_list&nocache=' + new Date().getTime()
                                            + '&page=' + {PAGE}
                                            + '&change_active=true&id=' + image_id
                                            + '&new_status=' + new_status);
    }

    // thông báo xoá:
    function notifyAlert(image_id) {
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
                    '{LANG.sweet_fire_title}',
                    '{LANG.sweet_fire_text}',
                    'success'
                ).then((result) => {
                    // xử lí:
                    window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=image_list&nocache=' + new Date().getTime()
                                            + '&page=' + {PAGE}
                                            + '&action_del=true&id=' + image_id
                                            + '&checksess=' + image_id + '{NV_CHECK_SESSION}');
                })
            }
        })
    }

    // hiển thị ảnh đại diện:
    function showImage(path, title) {
        Swal.fire({
            customClass: 'swal-wide',
            imageUrl: path,
            imageWidth: 600,
            // imageHeight: 250,
            imageAlt: title,
            confirmButtonText: '{LANG.zoom_out}',
        })
    }
</script>
<!-- END: main -->

