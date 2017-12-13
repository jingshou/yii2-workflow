$(function () {

    $('#frm-create').on('beforeSubmit', function (e) {
        var url = $(this).attr('action'),
            data = $(this).serialize(),
            yiiform = $(this);

        formSubmit('#btn-submit-create', url, data, yiiform);
        return false;
    });

    $('#btn-submit-sub-create').on('click', function () {
        return true;
    });
});

var formSubmit = function (btn, url, data, form) {

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
            ANLEWO.alert(res.msg, 'success').on(function () {
                location.reload();
            });
        } else if (res.validation) {
            $(form).yiiActiveForm('updateMessages', res.validation, true);
        } else {
            ANLEWO.alert(res.msg, 'error');
        }
    }).fail(function (res) {
        $(btn).button('reset');
        ANLEWO.alert(">_<, 出错了，请稍后再试或联系技术部~ ", 'error');
        return false;
    });
    return false;
}