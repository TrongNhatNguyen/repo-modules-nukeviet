<!-- BEGIN: main -->
<div class="news_column">
    <!-- BEGIN: loop -->
    <div class="panel panel-default">
        <div class="panel-body">
                <a href="{ALBUM.url_detail}" title="{ALBUM.title}" target="">
                    <img alt="{ALBUM.title}" src="{ALBUM.feature_image_path}" width="120" class="img-thumbnail pull-left imghome"/>
                </a>
            <h2>
                <a href="{ALBUM.url_detail}" target="">&nbsp; {ALBUM.title}</a>
            </h2>
            <div class="text-muted">
                <ul class="list-unstyled list-inline">
                    <li>&nbsp;
                        <em class="fa fa-clock-o">&nbsp;</em> {ALBUM.created_at}
                    </li>
                    <li>
                        <em class="fa fa-eye">&nbsp;</em> Đã xem: 0
                    </li>
                    <li>
                        <em class="fa fa-comment-o">&nbsp;</em> Phản hồi: 0
                    </li>
                </ul>
            </div>
            <!-- BEGIN: parent -->
            &nbsp; <a class="tag-parent" href="">{PARENT.title}</a>
            <!-- END: parent -->
            <div class="clearfix"></div>
            <p class="desc">{ALBUM.description}</p>
        </div>
    </div>
    <!-- END: loop -->

    <!-- phân trang -->
    {PAGINATE}
    <!-- BEGIN: notify -->
    {NOTIFY_EMPTY}
    <!-- END: notify -->
</div>

<style>
    .tag-parent {
        display: block;
        width: auto;
        float: left;
        font-size: 11px;
        margin: 0px 0px 9px 15px;
        padding: 3px 10px;
        text-align: center;
        background-color: #428bca;
        color: #fffdf9 !important;
        text-decoration: none;
        border-radius: 10px;
    }
    .tag-subcate:hover {
        background-color: rgb(69, 118, 163);
        color: #ffffff !important;
    }
    .desc {
        padding-top: 5px;
    }
</style>
<!-- END: main -->
