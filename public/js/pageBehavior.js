class pageBehavior {
    constructor() {
        this.bootstrapFunc()
        $(window).scroll(e => this.scrollFade())
        this.smoothScroll()
            // $(window).scroll(e => this.smoothFade())
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
        });

        //display waiting animation
        $('#wait-btn').on('click', e => {
            $('#wait-faw').removeClass("fab fa-firstdraft fa-paper-plane fa-unlock-alt");
            $('#wait-faw').addClass("fas fa-spinner fa-spin");
        });


    }

    scrollFade() {
        let scrollID = $('.scrollTo').attr('id')
        scrollID = scrollID.replace('scroll-to-', '')

        let distance = $('#scroll-to-' + scrollID).offset().top;

        if ($(window).scrollTop() >= distance) {
            $('.fv-scrollUp-Cont').fadeIn('slow');
        } else if ($(window).scrollTop() <= distance) {
            $('.fv-scrollUp-Cont').fadeOut('fast');
        }
    }

    smoothScroll() {
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