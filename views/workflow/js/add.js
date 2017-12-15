$(function () {

    $('#frm-create').on('beforeSubmit', function (e) {
        var url = $(this).attr('action'),
            data = $(this).serialize();

        formSubmit('#btn-submit-create', url, data);
        return false;
    });

    $('#btn-submit-create').on('click', function () {

        if ($('#workflowsearch-name').val() == '') {
            alert('审批名称不能为空');
            return false;
        }

        if ($('#workflowsearch-type option:selected').val() == '') {
            alert('审批类型不能为空');
            return false;
        }

        return true;
    });
});

var formSubmit = function (btn, url, data) {
    $(btn).button('loading');
    $.ajax({
        url: url,
        type: "post",
        data: data,
        cache: false,
        dataType: 'json',
    }).done(function (res) {
        $(btn).button('reset');
        if (res.success) {
            alert(res.msg);
            window.location.reload();
        } else {
            alert(res.msg);
        }
    }).fail(function (res) {
        $(btn).button('reset');
        alert(">_<, 出错了，请稍后再试或联系技术部~ ");
        return false;
    });
    return false;
}