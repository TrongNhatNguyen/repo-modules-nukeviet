<!-- BEGIN: main -->
<div class="table-responsive">

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">{LANG.stt}</th>
                <th>{LANG.title}</th>
                <th class="text-center">{LANG.feature_image_path}</th>
                <th>{LANG.description}</th>
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
                    <select name="weight" class="form-control weight_{ALBUM.id}" onchange="change_weight({ALBUM.id});">
                        <!-- BEGIN: weight -->
                        <option value="{STT}" {STT_SELECTED}>{STT}</option>
                        <!-- END: weight -->
                    </select>
                </td>

                <!-- tiêu đề -->
                <td class="w170">
                    <b>{ALBUM.title}</b>
                    <!-- BEGIN: parent_album -->
                    <a href="{ALBUM.url_edit}" class="small-title" title="{LANG.edit_palb_title}">{PARENT_ALBUM.title}</a>
                    <!-- END: parent_album -->
                </td>

                <!-- ảnh đại diện -->
                <td class="w110 align-midlle">
                    <img src="{ALBUM.feature_image_path}" alt="{ALBUM.title}" title="{LANG.zoom_in}" onclick="showFeatureImage('{ALBUM.feature_image_path}', '{ALBUM.title}');" style="width:100%;cursor: pointer;">
                </td>

                <!-- mô tả -->
                <td class="w350">{ALBUM.description}</td>

                <!-- hiển thị -->
                <td class="text-center align-middle">
                    <label class="switch">
                        <input type="checkbox" class="active_input_{ALBUM.id}" {ALBUM.active} onchange="change_active({ALBUM.id});"/>
                        <span class="slider round"></span>
                    </label>
                </td>

                <!-- ngày tạo -->
                <td class="text-center align-middle">{ALBUM.created_at} <br/> {ALBUM.updated_at}</td>

                <!-- thao tác -->
                <td class="text-center align-middle">
                    <div class="btn-group">
                        <a href="{ALBUM.url_edit}" class="btn btn-sm btn btn-primary text-white" data-toggle="tooltip" data-original-title="{LANG.edit_title}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            {LANG.edit}
                        </a>
                        <button type="button" class="btn btn-sm btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span><span class="sr-only">{LANG.edit}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{ALBUM.url_image_update}">{LANG.image_update}</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="notifyAlert('{ALBUM.id}');">
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
    .w110 {
        max-width: 110px;
    }
    .w170 {
        max-width: 170px;
    }
    .small-title {
        display: block;
        margin-top: 3px;
        font-size: smaller;
    }
    .small-title:hover {
        text-decoration: none;
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
    // thay đổi thứ tự:
    function change_weight(album_id) {
            var new_weight = $('.weight_' + album_id). val();
            window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                                + '=main&nocache=' + new Date().getTime()
                                                + '&page=' + {PAGE}
                                                + '&change_weight=true&id=' + album_id
                                                + '&new_weight=' + new_weight);
    }

    // thay đổi active:
    function change_active(album_id) {
        var new_status = 0;
        if ($('.active_input_' + album_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=main&nocache=' + new Date().getTime()
                                            + '&page=' + {PAGE}
                                            + '&change_active=true&id=' + album_id
                                            + '&new_status=' + new_status);
    }

    // thông báo xoá:
    function notifyAlert(album_id) {
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
                                            + '=main&nocache=' + new Date().getTime()
                                            + '&page=' + {PAGE}
                                            + '&action_del=true&id=' + album_id
                                            + '&checksess=' + album_id + '{NV_CHECK_SESSION}',
                    function (error) {
                        console.log(error);
                        if (error == "") {
                            Swal.fire(
                                '{LANG.sweet_fire_title_success}',
                                '{LANG.sweet_fire_text}',
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

    // hiển thị ảnh đại diện:
    function showFeatureImage(path, title) {
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

