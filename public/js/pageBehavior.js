class pageBehavior {
    constructor() {
        this.bootstrapFunc()
        this.smothFade()
        this.smothScroll()
    }

    bootstrapFunc() {

        //display file path in input Files
        $('.custom-file-input').on('change', function(event) {
            var inputFile = event.currentTarget;
            $(inputFile).parent()
                .find('.custom-file-label')
                .html(inputFile.files[0].name);
        });

        //display tootips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


    }

    smothFade() {

        var distance = $('#scroll-to').offset().top;

        $(window).scroll(function() {
            if ($(this).scrollTop() >= distance) {
                $('.fv-scrollUp-Cont').fadeIn('slow');

                let titleID = $('.title').attr('id')
                titleID = titleID.replace('title-', '')

                $('#title-' + titleID).removeClass('dispNone');
                $('#title-' + titleID).addClass('animated');
                $('#title-' + titleID).addClass('fadeInLeft');
            }

            if ($(this).scrollTop() <= distance) {
                $('.fv-scrollUp-Cont').fadeOut('fast');
            }
        });
    }

    smothScroll() {
        const sliderAnchor = $('#firstAnchor')[0]
        const homeAnchor = $('#homeAnchor')[0]

        $('#topAnchor').on('click', e => {
            sliderAnchor.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
            })
        });

        $('#upAnchor').on('click', e => {
            homeAnchor.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
            })
        });
    }
}