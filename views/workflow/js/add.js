$(function () {

    $('#frm-create').on('beforeSubmit', function (e) {
        var url = $(this).attr('action'),
            data = $(this).serialize();

        formSubmit('#btn-submit-create', url, data);
        return false;
    });

    $('#btn-submit-create').on('click', function () {

        if ($('#workflowsearch-name').val() == '') {
            showTooltip(this, '审批名称不能为空');
            return false;
        }

        if ($('#workflowsearch-type option:selected').val() == '') {
            showTooltip(this, '审批类型不能为空');
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
        if (res.success) {
            ANLEWO.alert(res.msg, 'success').on(function () {
                $(btn).button('reset');
                location.reload();
            });
        } else {
            ANLEWO.alert(res.msg, 'error');
            $(btn).button('reset');
        }
    }).fail(function (res) {
        $(btn).button('reset');
        ANLEWO.alert(">_<, 出错了，请稍后再试或联系技术部~ ", 'error');
        return false;
    });
    return false;
}

var showTooltip = function (btn, title) {
    $(btn).tooltip({
        container: 'body',
        title: title,
        placement: 'left',
        trigger: 'manual',
    }).tooltip('show');
    setTimeout(function () {
        $(btn).button('reset');
        $(btn).tooltip('destroy');
    }, 3000);
}