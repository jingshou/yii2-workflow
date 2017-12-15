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

    $(btn).attr('disabled');
    $.ajax({
        url: url,
        type: "post",
        data: data,
        cache: false,
        dataType: 'json',
    }).done(function (res) {
        $(btn).removeAttr('disabled');

        if (res.success) {
            alert(res.msg)
            window.location.reload();
        } else if (res.validation) {
            $(form).yiiActiveForm('updateMessages', res.validation, true);
        } else {
            alert(res.msg);
        }
    }).fail(function (res) {
        $(btn).removeAttr('disabled');
        alert(">_<, 出错了，请稍后再试或联系技术部~ ");
        return false;
    });
    return false;
}