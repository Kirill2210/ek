function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function clickOnApproveButton(e){
    var item = $(e.target).parents('.rew-item').first();
    var buttons = item.find('.rew-plus, .rew-minus');
    buttons.addClass('disabled');
}
$(function () {
    $('[placeholder]').placeholder();
    $('a[href^="#"]').click(function () {
        var elementClick = $(this).attr("href");
        var destination = $(elementClick).offset().top;
        jQuery("html:not(:animated), body:not(:animated)").animate({scrollTop: destination}, 800);
        return false;
    });
    $('#comment-form').on('submit', function (e) {
        alert('Комментарий принят!');
        $('#overlay').remove();
        $(".popup").fadeOut(100);
        $('#comment-form input[type=text]').val();
        $('#comment-form textarea').val();
        //$('#comment-form').reset();
        e.preventDefault();
        e.stopPropagation();

        return false;
    });
    $('span.add-rew').click(function () {
        $(".popup").fadeIn(500);
        $("body").append("<div id='overlay'></div>");
        $('#overlay').show().css('opacity', '0.8');
        $('a.close, #overlay').click(function () {
            $('.popup').fadeOut(100);
            $('#overlay').remove();
            return false;
        });
        $('.popup').click(function (e) {
            e.stopPropagation();
        });
        return false;
    });
    $('.animate').on('click', function (e) {
        var el = $(e.target);
        if (el[0].tagName.toLowerCase() == 'img') {
            el = el.parent();
        }
        var animateElements = el.parent().find('.animate');
        animateElements.removeClass('active');
        el.addClass('active');
        var img = el.find('img');
        var url = img.attr('src');
        var target = el.attr('data-target');
        $(target).attr('src', url);
    });

    $('.rew-plus, .rew-minus').on('click', clickOnApproveButton);
});
 