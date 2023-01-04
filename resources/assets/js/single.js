$(document).ready(function () {
    $('.play-trailer').on('click', function (e) {
        e.preventDefault();
        var youtubeId = $(this).attr('href').match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        if (youtubeId && youtubeId[1] != null && youtubeId[1] != 'undefined') {
            var vidWidth = 560;
            var vidHeight = 320;
            if ($(this).attr('data-width')) {
                vidWidth = parseInt($(this).attr('data-width'));
            }
            if ($(this).attr('data-height')) {
                vidHeight = parseInt($(this).attr('data-height'));
            }
            var iFrameCode = '<iframe width="' + vidWidth + '" height="' + vidHeight + '" scrolling="no" allowtransparency="true" allowfullscreen="true" src="https://www.youtube.com/embed/' + youtubeId[1] + '?rel=0&wmode=transparent&showinfo=0&hd=1" frameborder="0"></iframe>';
            $('#mediaModal .modal-body').html(iFrameCode);
            $('#mediaModal').on('show.bs.modal', function () {
                var modalBody = $(this).find('.modal-body');
                var modalDialog = $(this).find('.modal-dialog');
                var newModalWidth = vidWidth + parseInt(modalBody.css("padding-left")) + parseInt(modalBody.css("padding-right"));
                newModalWidth += parseInt(modalDialog.css("padding-left")) + parseInt(modalDialog.css("padding-right"));
                newModalWidth += 'px';
                $(this).find('.modal-dialog').css('width', newModalWidth);
            });
            $('#mediaModal').modal();
        }
    });
    $('.comingsoon').on('click', function (e) {
        e.preventDefault();
        var youtubeId = $('.play-trailer').attr('href')?.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        if (youtubeId && youtubeId[1] != null && youtubeId[1] != 'undefined') {
            var vidWidth = 560;
            var vidHeight = 320;
            if ($(this).attr('data-width')) {
                vidWidth = parseInt($(this).attr('data-width'));
            }
            if ($(this).attr('data-height')) {
                vidHeight = parseInt($(this).attr('data-height'));
            }
            var iFrameCode = '<iframe width="' + vidWidth + '" height="' + vidHeight + '" scrolling="no" allowtransparency="true" allowfullscreen="true" src="https://www.youtube.com/embed/' + youtubeId[1] + '?rel=0&wmode=transparent&showinfo=0&hd=1" frameborder="0"></iframe>';
            $('#mediaModal .modal-body').html(iFrameCode);
            $('#mediaModal').on('show.bs.modal', function () {
                var modalBody = $(this).find('.modal-body');
                var modalDialog = $(this).find('.modal-dialog');
                var newModalWidth = vidWidth + parseInt(modalBody.css("padding-left")) + parseInt(modalBody.css("padding-right"));
                newModalWidth += parseInt(modalDialog.css("padding-left")) + parseInt(modalDialog.css("padding-right"));
                newModalWidth += 'px';
                $(this).find('.modal-dialog').css('width', newModalWidth);
            });
            $('#mediaModal').modal();
        }
    });
    $('#mediaModal').on('hidden.bs.modal', function () {
        $('#mediaModal .modal-body').html('');
    });
});
