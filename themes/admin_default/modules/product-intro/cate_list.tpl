<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/admin_default/css/select2.min.css"/>
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/admin_default/css/product-intro.css"/>

<!---------------------------------------------------->
<!-- BEGIN: error -->
<div class="alert alert-danger" role="alert">{ERROR}</div>
<!-- END: error -->
<!-- BEGIN: success -->
<div class="alert alert-success" role="alert">{SUCCESS}</div>
<!-- END: success -->

<div class="well">
    <table class="table">
        <!-- BEGIN: caption -->
        <caption><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> {CAPTION}</caption>
        <!-- END: caption -->
    </table>

    <form enctype="multipart/form-data" action="{FORM_DATA.url_action}" method="POST">
        <input type="hidden" name="id" value="{FORM_DATA.id}"/>
        <div class="row">
            <!-- Tên danh mục -->
            <div class="col-sm-12 col-md-6">
                <label for="name" class="control-label">{LANG.cate_name} <sup class="required">(*)</sup></label>
                <input type="text" class="form-control" name="name" id="inputTitle" value="{FORM_DATA.name}" placeholder="{LANG.cate_name}">
            </div>

            <!-- liên kết tĩnh -->
            <div class="col-sm-12 col-md-6">
                <label for="alias" class="control-label">{LANG.alias} <sup class="required">(*)</sup></label>
                <input type="text" class="form-control" name="alias" id="inputAlias" value="{FORM_DATA.alias}" placeholder="{LANG.alias}">
            </div>

            <!-- Danh mục cha -->
            <div class="col-sm-12 col-md-6">
                <label for="parentCate" class="control-label">{LANG.parent_cate} <sup class="required">(*)</sup></label>
                <select name="parent_id" id="cateSelect" class="select2" style="width: 100%;">
                    <option value="0">{LANG.def_parent_cate_option}</option>
                    <!-- BEGIN: parent_cate -->
                    {PARENT_OPTION}
                    <!-- END: parent_cate -->
                </select>
            </div>

            <div class="col-sm-12 col-md-4">
                <!-- hiển thị -->
                <div class="css-active pull-left">
                    <label for="check_active" class="control-label">{LANG.active} <sup class="required">(*)</sup></label>
                    <label class="switch">
                        <input type="checkbox" name="check_active" {FORM_DATA.active}/>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <!-- submit -->
                <label for="" class="control-label"></label>
                <button name="form_submit" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; {LANG.submit}</button>
            </div>
        </div>

        <!-- note -->
        <!-- <label><em>Từ khóa tìm kiếm không lớn hơn 64 ký tự, không dùng các mã html</em></label> -->
    </form>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.list_cate}</caption>
        <thead>
            <tr>
                <th class="text-center">{LANG.stt}</th>
                <th class="text-center">{LANG.cate_name}</th>
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
                    <select name="weight" class="form-control weight_{CATE.id}" onchange="change_weight({CATE.id});">
                        <!-- BEGIN: weight -->
                        <option value="{STT}" {STT_SELECTED}>{STT}</option>
                        <!-- END: weight -->
                    </select>
                </td>

                 <!-- name -->
                <td class="w400">
                    <b>{CATE.name}</b>
                    <!-- BEGIN: parent_cate -->
                    <a href="{CATE.url_edit}" class="small-title" title="{LANG.edit_pcate_title}">{PARENT_CATE.name}</a>
                    <!-- END: parent_cate -->
                </td>

                 <!-- active -->
                <td class="text-center align-middle">
                    <label class="switch">
                        <input type="checkbox" class="active_input_{CATE.id}" {CATE.active} onchange="change_active({CATE.id});"/>
                        <span class="slider round"></span>
                    </label>
                </td>

                 <!-- ngày tạo -->
                <td class="text-center align-middle">{CATE.created_at} <br/> {CATE.updated_at}</td>
                
                 <!-- thao tác -->
                <td class="text-center align-middle">
                    <a class="btn btn-primary btn-sm btn_edit" href="{CATE.url_edit}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {LANG.edit}
                    </a>
                    <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="notifyAlert('{CATE.id}');">
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
<script src="{NV_BASE_SITEURL}themes/admin_default/js/select2.min.js"></script>
<script src="{NV_BASE_SITEURL}themes/admin_default/js/product-intro.js"></script>
<script type="text/javascript">
    let sPageURL = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&nocache=' + new Date().getTime() + '&page={PAGE}';

    $(document).ready(function() {
        $(".select2").select2();
    });

    // thay đổi thứ tự:
    function change_weight(cate_id) {
            let new_weight = $('.weight_' + cate_id).val();
            window.location.replace(sPageURL + '&change_weight=true&id=' + cate_id + '&new_weight=' + new_weight);
    }

    // thay đổi active:
    function change_active(cate_id) {
        let new_status = 0;
        if ($('.active_input_' + cate_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(sPageURL + '&change_active=true&id=' + cate_id + '&new_status=' + new_status);
    }

    // thông báo xoá:
    function notifyAlert(cate_id) {
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
                $.get(sPageURL + '&action_del=true&id=' + cate_id + '&checksess=' + cate_id + '{NV_CHECK_SESSION}',
                    function (error) {
                        console.log(error);
                        if (error == "") {
                            Swal.fire(
                                '{LANG.sweet_fire_title_success}',
                                '{LANG.sweet_fire_text_del}',
                                'success'
                            ).then((result) => {
                                window.location.replace(sPageURL);
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
</script>
<!-- END: main -->
