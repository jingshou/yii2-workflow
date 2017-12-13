$(function () {

    // 添加明细
    $('#add-WorkflowSub-Button').on('click', function () {
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: "GET",
            cache: false,
            data: {}
        }).done(function (res) {
            $('#add-workflow-sub-con').modal({backdrop: 'static', keyboard: true});
            $("#add-workflow-sub-con").html(res).modal('show');
        }).fail(function (res) {
            ANLEWO.alert(">_<, 服务器受到一个爆击导致失败，请稍后再试~ ", 'error');
            return false;
        });
    });
});