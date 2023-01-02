$(document).on('click', '#but_send_report', function () {
    var log_des = $('#log_des').val() ?? '';
    $.ajax({
        url: URL_POST_REPORT,
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                'content')
        },
        dataType: 'json',
        data: JSON.stringify({ message: log_des })
    }).done(function (data) {
        var str = "Gửi báo lỗi thành công!";
        setTimeout(function () {
            $('#ModalBaoloi').modal('hide');
        }, 1000);
        $('#show_msg').html(str);
        $("#ModalBaoloi").modal();
        $('#report_error').remove();
    }).fail(function () {
        console.log('error-connection');
    });
});
