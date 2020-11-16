class backBehavior {
    constructor() {
        this.bootstrapFunc()
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
}