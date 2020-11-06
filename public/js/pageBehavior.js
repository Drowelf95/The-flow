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

        $('#wait-btn').on('click', e => {
            $('#wait-faw').removeClass("fab fa-firstdraft fa-paper-plane fa-unlock-alt");
            $('#wait-faw').addClass("fas fa-spinner fa-spin");
        })


    }

    smothFade() {

        let scrollID = $('.scrollTo').attr('id')
        scrollID = scrollID.replace('scroll-to-', '')

        let distance = $('#scroll-to-' + scrollID).offset().top;

        $(window).scroll(function() {
            if ($(this).scrollTop() >= distance) {
                $('.fv-scrollUp-Cont').fadeIn('slow');

                let titleID = $('.title').attr('id')
                titleID = titleID.replace('title-', '')

                $('#title-' + titleID).removeClass('dispNone');
                $('#title-' + titleID).addClass('animated');
                $('#title-' + titleID).addClass('fadeInLeft');
            } else if ($(this).scrollTop() <= distance) {
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