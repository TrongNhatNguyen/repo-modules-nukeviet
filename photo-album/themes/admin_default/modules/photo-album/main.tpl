<!-- BEGIN: main -->
<div class="table-responsive">

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">{LANG.stt}</th>
                <th>{LANG.name}</th>
                <th>{LANG.description}</th>
                <th>{LANG.cate}</th>
                <th>{LANG.active}</th>
                <th>{LANG.created_at} / {LANG.updated_at}</th>
                <th class="text-center">{LANG.action}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center align-middle">{ALBUM.stt}</td>
                <td class="w150">{ALBUM.name}</td>
                <td class="w400">{ALBUM.description}</td>
                <td class="w150">{ALBUM.subcate.name} <br/> <span style="font-size: 12px; color: rgb(42, 42, 143);">{ALBUM.cate.name}</span></td>
                <td class="text-center align-middle">{ALBUM.active}</td>
                <td>{ALBUM.created_at} <br/> {ALBUM.updated_at}</td>
                <td class="text-center align-middle">
                    <a class="btn btn-primary btn-sm btn_edit" href="{ALBUM.url_edit}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {LANG.edit}
                    </a>
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


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function notifyAlert(album_id) {
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
                                            + '=main&nocache=' + new Date().getTime()
                                            + '&notifyAlert=true&id=' + album_id + '&action_del=true'
                                            + '&checksess=' + album_id + '{NV_CHECK_SESSION}');
                })
            }
        })
    }
</script>
<!-- END: main -->

