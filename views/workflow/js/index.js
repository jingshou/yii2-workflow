$(function () {

    // 新增
    $('#add-Workflow-Button').on('click', function () {
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: "GET",
            cache: false,
            data: {}
        }).done(function (res) {
            $('#add-workflow-con').modal({backdrop: 'static', keyboard: true});
            $("#add-workflow-con").html(res).modal('show');
        }).fail(function (res) {
            alert(">_<, 服务器受到一个爆击导致失败，请稍后再试~ ");
            return false;
        });
    });

    // 编辑
    $('.workflow-edit').on('click', function () {
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: "GET",
            cache: false,
            data: {}
        }).done(function (res) {
            $('#add-workflow-con').modal({backdrop: 'static', keyboard: true});
            $("#add-workflow-con").html(res).modal('show');
        }).fail(function (res) {
            alert(">_<, 服务器受到一个爆击导致失败，请稍后再试~ ");
            return false;
        });

        return false;
    });

    // 删除
    $('.workflow-del').on('click', function () {
        $(this).button('loading');
        var btn = this,
            url = $(this).attr('href');

        if (confirm('确认删除？')) {

            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                data: {}
            }).done(function (res) {
                if (res.success) {
                    alert('删除成功');
                    window.location.reload();
                } else {
                    alert('删除失败');
                }
            }).fail(function (res) {
                alert(">_<, 服务器受到一个爆击导致失败，请稍后再试~ ");
                return false;
            });
        }else{
            $(this).button('reset');
        }

        return false;
    });

})


