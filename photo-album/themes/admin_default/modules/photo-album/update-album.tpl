<!-- BEGIN: main -->
<div class="col-24">
    <!-- BEGIN: error -->
    <label class="col-3 control-label"></label>
    <div class="col-19 alert alert-danger" role="alert">{ERROR}</div>
    <!-- END: error -->
    <!-- BEGIN: success -->
    <label class="col-3 control-label"></label>
    <div class="col-19 alert alert-success" role="alert">{SUCCESS}</div>
    <!-- END: success -->


    <div class="well">
        <form class="form-horizontal" enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="POST">
            <input type="hidden" name="id" value="{FORM_DATA.id}"/>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">{LANG.name} <sup class="required">(*)</sup></label>
                <div class="col-sm-19">
                    <input type="text" class="form-control" name="name" id="inputName" value="{FORM_DATA.name}" placeholder="{LANG.name}">
                </div>
            </div>
            <div class="form-group">
                <label for="alias" class="col-sm-3 control-label">{LANG.alias} <sup class="required">(*)</sup></label>
                <div class="col-sm-19">
                    <input type="text" class="form-control" name="alias" id="inputAlias" value="{FORM_DATA.alias}" placeholder="{LANG.alias}">
                </div>
            </div>
            <div class="form-group">
                <label for="cate" class="col-sm-3 control-label">{LANG.cate} <sup class="required">(*)</sup></label>
                <div class="col-sm-7">
                    <select name="cate_id" id="cateSelect" class="select2 form-control" style="width: 100%">
                        <!-- BEGIN: cate.loop -->
                        {CATE_OPTION}
                        <!-- END: cate.loop -->
                    </select>
                </div>
                <label for="subcate" class="col-sm-4 control-label">{LANG.subcate} <sup class="required">(*)</sup></label>
                <div class="col-sm-8">
                    <select name="subcate_id" id="subcateSelect" class="select2 form-control" style="width: 100%">
                        <!-- BEGIN: subcate.loop -->
                        {SUBCATE_OPTION}
                        <!-- END: subcate.loop -->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="subcate" class="col-sm-3 control-label">{LANG.image}</label>
                <div class="col-sm-19">
                    <input class="w300 form-control pull-left" type="text" name="image" id="image" value="{FORM_DATA.image}" style="margin-right: 5px"/>
                    <input type="button" value="Browse server" name="selectimg" class="btn btn-info"/>
                </div>
            </div>
            <div class="form-group">
                <label for="alias" class="col-sm-3 control-label">{LANG.description}</label>
                <div class="col-sm-19">
                    {FORM_DATA.description}
                </div>
            </div>
            <div class="form-group">
                <label for="active" class="col-sm-3 control-label">{LANG.active} <sup class="required">(*)</sup></label>
                <div class="col-sm-5">
                    <label class="switch">
                        <input type="checkbox" name="check_active" {FORM_DATA.active}/>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
    
            <!-- submit -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-19">
                    <button name="form_submit" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; {LANG.submit}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<style>
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
        // convert alias:
        $('#inputAlias').keyup(function () {
            var text = $(this).val();
            text = text
                .toUpperCase().toLowerCase()
                .normalize('NFD')
                .replace(/ +|_/g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
            $("#inputAlias").val(text);  
        });

        // change cate -> subcate:
        $('body').on('change', '#cateSelect', function (event) {
            cate_id = $('#cateSelect').val();
            $.ajax({
                type: 'GET',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable
                    + '=update-album&nocache=' + new Date().getTime()
                    + '&change_cate=true&cate_id=' + cate_id,
                context: document.body
            }).done(function(html) {
                $('#subcateSelect').html(html);
            });
        })

        // upload file:
        $("input[name=selectimg]").click(function() {
            var area = "image"; //id của thẻ input lưu đường dẫn file
            var alt = "imagealt"; //id của thẻ input lưu tiêu đề file
            var path = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}'; //uploads folder
            var type = "image"; // kiểu định dạng cho phép upload
                    var currentpath = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}'; //uploads folder
    
            nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&alt=" + alt + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    
            return false;
        });
    });
</script>
<!-- END: main -->
