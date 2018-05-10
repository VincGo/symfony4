$('#chat form').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(e.target);
        $.ajax({
            processData: false,
            contentType: false,
            url : $(this).attr('action'),
            type : 'POST',
            data : formData
        });
    $('.form-control').val('');

});


function charger() {

    setTimeout( function () {
        var message = $('#messages p:last');
        var lastMsg = message.attr('data-id');
        var team = message.attr('data-team');
        var msg = $('#messages');

        $.ajax({
            url : "/chat/" + team + "/refresh/" + lastMsg,
            dataType : 'html',
            success : function (html) {
                msg.append(html);
                msg.scrollTop(9000);
            }
        });

        charger();

    }, 1000);
}

charger();


