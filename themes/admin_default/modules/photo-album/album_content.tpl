<!-- BEGIN: main -->
<div class="col-md-2"></div>
<div class="col-md-20 col-sm-24">
    <!-- BEGIN: error -->
    <div class="alert alert-danger" role="alert">{ERROR}</div>
    <!-- END: error -->
    <!-- BEGIN: success -->
    <div class="alert alert-success" role="alert">{SUCCESS}</div>
    <!-- END: success -->

    <form enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="POST" class="confirm-reload">
        <input type="hidden" name="id" value="{FORM_DATA.id}"/>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                        <!-- tiêu đề -->
                        <tr>
                            <td class="text-right align-middle">{LANG.title} <sup class="required">(*)</sup></td>
                            <td>
                                <input type="text" class="form-control" name="title" id="inputTitle" value="{FORM_DATA.title}" placeholder="{LANG.title}">
                            </td>
                        </tr>

                        <!-- liên kết tĩnh -->
                        <tr>
                            <td class="text-right align-middle">{LANG.alias} <sup class="required">(*)</sup></td>
                            <td>
                                <input type="text" class="form-control" name="alias" id="inputAlias" value="{FORM_DATA.alias}" placeholder="{LANG.alias}">
                            </td>
                        </tr>

                        <!-- album gốc -->
                        <tr>
                            <td class="text-right align-middle">{LANG.parent_album}</td>
                            <td>
                                <select name="parent_id" id="cateSelect" class="select2 w400 form-control">
                                    <!-- BEGIN: loop-parent -->
                                    {PARENT_OPTION}
                                    <!-- END: loop-parent -->
                                </select>
                            </td>
                        </tr>

                        <!-- ảnh đại diện -->
                        <tr>
                            <td class="text-right align-middle">{LANG.feature_image_path}</td>
                            <td>
                                <input class="w400 form-control pull-left" type="text" name="feature_image_path" id="image" value="{FORM_DATA.feature_image_path}" readonly/>
                                <input type="hidden" id="imagealt"/>
                                <input type="button" value="Browse server" name="selectimg" class="btn btn-info" style="margin-left: 5px;"/>
                            </td>
                        </tr>

                        <!-- mô tả -->
                        <tr>
                            <td class="text-right align-middle">{LANG.description} <sup class="required">(*)</sup></td>
                            <td>
                                <textarea class="form-control" name="description" id="desc" cols="150" rows="3" placeholder="{LANG.description}...">{FORM_DATA.description}</textarea>
                            </td>
                        </tr>

                        <!-- nội dung -->
                        <tr>
                            <td colspan="2" class="strong">
                                <label for="alias" class="control-label">{LANG.content}</label>
                                {FORM_DATA.content}
                            </td>
                        </tr>

                        <!-- hiển thị -->
                        <tr>
                            <td class="text-right strong">{LANG.active} <sup class="required">(*)</sup></td>
                            <td class="strong">
                                <label class="switch">
                                    <input type="checkbox" name="check_active" {FORM_DATA.active}/>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- submit -->
        <div class="row text-center">
            <button name="form_submit" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; {LANG.submit}</button>
        </div>
    </form>
</div>
<div class="clearfix"></div>


<style>
    tr > td {
        vertical-align: middle !important;
    }
    .switch {
    position: relative;
    display: inline-block;
    top: 3px;
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

<script type="text/javascript">
    var $disabledResults = $(".select2");
    $disabledResults.select2();

    $(document).ready(function() {
        // tự động nhập alias khi nhập title:
        $('body').on('keyup', '#inputTitle', function(event) {
            var value = $('#inputTitle').val();
            value = convertAlias(value);
            $("#inputAlias").val(value.split(/\s{1,}/g).join('-'));
        });

        // convert alias:
        $('#inputAlias').keyup(function () {
            var text = $(this).val();
            $("#inputAlias").val(convertAlias(text));  
        });

        // upload file:
        $("input[name=selectimg]").click(function() {
            var area = "image"; //id của thẻ input lưu đường dẫn file
            var alt = "imagealt"; //id của thẻ input lưu tiêu đề file
            var type = "image"; // kiểu định dạng cho phép upload
            var path = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}'; //show curent folder
            var currentpath = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}'; //save image folder
    
            nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&alt=" + alt + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    
            return false;
        });
    });

    function convertAlias(text) {
        return text.toUpperCase().toLowerCase()
            .split(/đ|Đ/g).join('d')
            .normalize('NFD')
            .replace(/ +|_/g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
    }
</script>
<!-- END: main -->
