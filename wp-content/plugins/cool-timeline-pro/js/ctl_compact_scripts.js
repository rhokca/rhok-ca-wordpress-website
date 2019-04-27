(function($) {
    //Masonary First Load
    function masonaryFirstload() {
        
        var left_plus = 0;
        var right_plus = 0;

        $('.compact-wrapper .clt-compact-cont').masonry({
            itemSelector: '.timeline-mansory'
        });
        $('.compact-wrapper .clt-compact-cont').find('.timeline-mansory').each(function(index) {

           
            var leftPos = $(this).position().left;

            if (leftPos <= 0) {
                var topPos = $(this).position().top + left_plus;
                $(this).addClass('ctl-left');
            } else {
                var topPos = $(this).position().top + right_plus;;
                $(this).addClass('ctl-right');
            }

            if ($(this).next('.timeline-post').length > 0) {
                var next_leftPos = $(this).next().position().left;
                if (next_leftPos <= 0) {
                    var second_topPos = $(this).next().position().top + left_plus;
                } else {
                    var second_topPos = $(this).next().position().top + right_plus;
                }
                var top_gap = second_topPos - topPos;
                if (top_gap <= 44) {
                    if (leftPos <= 0) {
                        right_plus = right_plus + 44 - top_gap;
                    } else {
                        left_plus = left_plus + 44 - top_gap;
                    }
                }
            }

            var firstHeight = $(this).outerHeight(true);
            var firstBottom = topPos + firstHeight + 60;


            $(this).css({
                'top': topPos + 'px'
            });

            $('.compact-wrapper .cooltimeline_cont').css({
                'height': 'auto'
            });
            $('.compact-wrapper .clt-compact-cont').css({
                'height': firstBottom + 'px'
            });

        });

    }

    //Masonary Second Load
    function masonarySecondload() {
        

        var left_plus = 0;
        var right_plus = 0;
        var lastBottom = 0;
        var i = 0;

        //$('.timeline-mansory').removeClass("ctl-right").removeClass("ctl-left");

        
        setTimeout(function() {
            $('.compact-wrapper .clt-compact-cont').masonry({
                itemSelector: '.timeline-mansory'
            });
        }, 650);
        setTimeout(function() {

            $(".timeline-icon").addClass("showit");
            $(".content-title").addClass("showit-after");

            $('.compact-wrapper .clt-compact-cont').find('.timeline-mansory').each(function(index) {

                var leftPos = $(this).position().left;

                if (leftPos <= 0) {
                    var topPos = $(this).position().top + left_plus;
                    $($(".timeline-mansory").get(i)).removeClass("ctl-right");
                    $(this).addClass('ctl-left');
                } else {
                    var topPos = $(this).position().top + right_plus;
                    $($(".timeline-mansory").get(i)).removeClass("ctl-left");
                    $(this).addClass('ctl-right');
                }

                i++;

                if ($(this).next('.timeline-post').length > 0) {
                    var next_leftPos = $(this).next().position().left;
                    if (next_leftPos <= 0) {
                        var second_topPos = $(this).next().position().top + left_plus;
                    } else {
                        var second_topPos = $(this).next().position().top + right_plus;
                    }
                    var top_gap = second_topPos - topPos;
                    if (top_gap <= 44) {
                        if (leftPos <= 0) {
                            right_plus = right_plus + 44 - top_gap;
                        } else {
                            left_plus = left_plus + 44 - top_gap;
                        }
                    }
                }

                var firstHeight = $(this).outerHeight(true);
                var firstBottom = topPos + firstHeight + 60;

                $(this).css({
                    'top': topPos + 'px'
                });

                if (lastBottom < firstBottom) {
                    $('.compact-wrapper .cooltimeline_cont').css({
                        'height': 'auto'
                    });
                    $('.compact-wrapper .clt-compact-cont').css({
                        'height': firstBottom + 'px'
                    });

                    lastBottom = firstBottom;
                } else {
                    $('.compact-wrapper .cooltimeline_cont').css({
                        'height': 'auto'
                    });
                    $('.compact-wrapper .clt-compact-cont').css({
                        'height': lastBottom + 'px'
                    });               
                }

            });

        }, 1250);

    }


    $(window).on("load resize", function() {
        masonarySecondload();
    });

    $('body').on('click', '.ctl_load_more', function() {
        masonarySecondload();
    });

    $('.ct-cat-filters').click(function() {
        masonarySecondload();
    });

    $(document).ready(function() {
        masonaryFirstload();
    });

})(jQuery);