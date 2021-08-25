<!-- BEGIN: main -->
<div class="col-24">
    <div class="row">
        <!-- LEFT -->
        <div class="col-md-15">
            <!-- option -->
            <div class="form-group">
                <form class="form-inline">
                    <label for="cate">Show theo:</label>
                    <select id="cateSelectSearch" class="select2 w250 form-control">
                        <!-- BEGIN: cate-loop -->
                        {CATE_SEARCH_OPTION}
                        <!-- END: cate-loop -->
                    </select>
                </form>
            </div>            

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">{LANG.stt}</th>
                            <th>{LANG.name}</th>
                            <th>{LANG.active}</th>
                            <th>{LANG.created_at} / {LANG.updated_at}</th>
                            <th class="text-center">{LANG.action}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr>
                            <td class="text-center align-middle">
                                <select name="weight" class="form-control weight_{SUBCATE.id}" onchange="change_weight({SUBCATE.id});">
                                    <!-- BEGIN: weight -->
                                    <option value="{STT}" {STT_SELECTED}>{STT}</option>
                                    <!-- END: weight -->
                                </select>
                            </td>
                            <td class="w200">{SUBCATE.name}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="active_input_{SUBCATE.id}" name="check_active" {SUBCATE.active} onchange="change_active({SUBCATE.id});"/>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>{SUBCATE.created_at} <br/> {SUBCATE.updated_at}</td>
                            <td class="text-center align-middle">
                                <a class="btn btn-primary btn-sm btn_edit" href="{SUBCATE.url_edit}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {LANG.edit}
                                </a>
                                <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="notifyAlert('{SUBCATE.id}');">
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
        </div>

        <!-- RIGHT -->
        <div class="col-md-9">
            <!-- BEGIN: error -->
            <div class="alert alert-danger" role="alert">{ERROR}</div>
            <!-- END: error -->
            <!-- BEGIN: success -->
            <div class="alert alert-success" role="alert">{SUCCESS}</div>
            <!-- END: success -->

            <div class="well">
                <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="POST">
                    <input type="hidden" name="id" value="{FORM_DATA.id}"/>
                    <div class="form-group">
                        <label for="name" class="control-label">{LANG.name} <sup class="required">(*)</sup></label>
                        <input type="text" class="form-control" name="name" id="inputName" value="{FORM_DATA.name}" placeholder="{LANG.name}">
                    </div>
                    <div class="form-group">
                        <label for="alias" class="control-label">{LANG.alias} <sup class="required">(*)</sup></label>
                        <input type="text" class="form-control" name="alias" id="inputAlias" value="{FORM_DATA.alias}" placeholder="{LANG.alias}">
                    </div>
                    <div class="form-group">
                        <label for="cate" class="control-label">{LANG.cate} <sup class="required">(*)</sup></label>
                        <select id="selectCate" name="cate_id" class="select2 form-control">
                            <!-- BEGIN: cate-loop -->
                            {CATE_OPTION}
                            <!-- END: cate-loop -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="active" class="control-label">{LANG.active} <sup class="required">(*)</sup></label>
                        <label class="switch">
                            <input type="checkbox" name="check_active" {FORM_DATA.active}/>
                            <span class="slider round"></span>
                        </label>
                    </div>
    
                    <!-- submit -->
                    <div class="form-group">
                        <button name="form_submit" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; {LANG.submit}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .switch {
        position: relative;
        display: inline-block;
        top: -3px;
        left: 5px;
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
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    var $disabledResults = $(".select2");
    $disabledResults.select2();

    $(document).ready(function() {
        // convert alias:
        $('#inputAlias').keyup(function () {
            var text = $(this).val();
            text = text
                .toUpperCase().toLowerCase()
                .normalize('NFD')
                .replace(/ +|_/g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
            $("#inputAlias").val(text);  
        });

        // show subcate theo cate:
        $('body').on('change', '#cateSelectSearch', function (event) {
            cate_id = $('#cateSelectSearch').val();
            window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                    + '=list-subcate&nocache=' + new Date().getTime()
                    + '&change_cate=true&cate_id=' + cate_id);
        });
    });

    // thay đổi active:
    function change_active(subcate_id) {
        var new_status = 0;
        if ($('.active_input_' + subcate_id).is(":checked")) {
            new_status = 1;
        }

        window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=list-subcate&nocache=' + new Date().getTime()
                                            + '&change_active=true&id=' + subcate_id
                                            + '&new_status=' + new_status);
    }

    // thay đổi thứ tự:
    function change_weight(subcate_id) {
        var new_weight = $('.weight_' + subcate_id).val();
        window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=list-subcate&nocache=' + new Date().getTime()
                                            + '&change_weight=true&id=' + subcate_id
                                            + '&new_weight=' + new_weight);
    }

    // thông báo xoá:
    function notifyAlert(subcate_id) {
        Swal.fire({
            title: 'Bạn Chắc Chứ?',
            text: "Bạn không thể phục hồi điều này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xoá Luôn!',
            cancelButtonText: 'Huỷ Bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Thành Công!',
                    'Dữ liệu đã được xoá.',
                    'success'
                ).then((result) => {
                    // xử lí:
                    window.location.replace(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                                            + '=list-subcate&nocache=' + new Date().getTime()
                                            + '&notifyAlert=true&id=' + subcate_id + '&action_del=true'
                                            + '&checksess=' + subcate_id + '{NV_CHECK_SESSION}');
                })
            }
        })
    }
</script>
<!-- END: main -->


