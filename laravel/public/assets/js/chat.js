/**
 * Created by tutv95 on 06/11/2015.
 */

jQuery(document).ready(function ($) {
    var url_ajax = $('#url_ajax').attr('data-url');

    $('#text_chat').keyup(function (event) {
        if (event.keyCode == 13) {
            var text = $(this).val();
            if (text == '') {
                return;
            }
            getAnswer(text);
            $(this).val('');
        }
    });

    $('#btn_chat').click(function () {
        var text = $('#text_chat').val();
        if (text == '') {
            return;
        }
        getAnswer(text);
        $('#text_chat').val('');
    });

    function getAnswer(text) {
        $.ajax({
            url: url_ajax,
            method: 'POST',
            data: {question: text},
            dataType: 'json',
            success: function (response) {
                if (response.status == 'OK') {
                    var html = '<div class="msg_bot">';
                    html += 'Human: ' + response.question + '<br>';
                    html += 'Bot: ' + response.answer + '</div>';

                    $('#content_chat').prepend(html);
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    }

    $('#filter').on('change', function () {
        var select = $(this).val();
        var tag_no_answer = 'noanswer';

        if (select == 'all') {
            $('.qa').show();
        } else {
            var qas = $('.qa');
            qas.each(function (index) {
                var answer = $(this).html();
                if (answer.indexOf(tag_no_answer) == -1) {
                    $(this).hide();
                }
            });
        }
    });
});