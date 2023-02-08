(function ($) {


     /*ZOOM User Credentials*/
    $(document).on('submit', '.exertio_zoom_auth', function (e) {
        e.preventDefault();

        var _this = jQuery(this);
        var this_form = _this;
        var freelanceAjaxURL = $("#freelance_ajax_url").val();
        $.post(freelanceAjaxURL, {
            action: 'exertio_get_user_credentials',
            form_data: $("form.exertio_zoom_auth").serialize(),
        }).done(function (response) {

            window.location.reload();


        });
    });

    /*ZOOM Meeting Authorization*/
    $('.meeting_authorization').click(function () {

        var this_value = $(this);
        var freelancer_id = $(this).attr('data-fl-id');
        var project_id = $(this).attr('data-pid');

        this_value.find('span.bubbles').addClass('view');
        $(".meeting_authorization").attr("disabled", true);
        var freelanceAjaxURL = $("#freelance_ajax_url").val();
        $.post(freelanceAjaxURL, {
            freelancer_id: freelancer_id,
            project_id: project_id,
            action: 'exertio_zoom_auth_user',
        }).done(function (response) {
            //console.log("1", response);

            var zoom_auth_window = window.open(response,
                    '', 'scrollbars=no,menubar=no,resizable=yes,toolbar=no,status=no,width=800, height=400');

            //console.log("aaaaa", zoom_auth_window.closed);
            var auth_window_timer = setInterval(function () {

                var winValue = ''
                if (winValue === "") {
                    winValue = zoom_auth_window;
                }
                window.onmessage = function (e) {
                    if (e.data) {
                        if (zoom_auth_window.closed) {
                            /*Meetings Form for creation*/
                            // $('#meeting_date').datetimepicker({
                            // format: 'Y-m-d H:i'
                            // });
                            this_value.find('span.bubbles').addClass('view');
                            $(".meeting_authorization").attr("disabled", true);
                            var freelanceAjaxURL = $("#freelance_ajax_url").val();

                            $.post(freelanceAjaxURL, {
                                freelancer_id: freelancer_id,
                                project_id: project_id,
                                action: 'exertio_load_zoom_meeting_form',
                            }).done(function (response) {
                                $("#zoom_meeting_container").html(response);
                                $('.zoom-meeting-popup').modal('show');
                                $(".meeting_authorization").attr("disabled", false);

                            });
                            clearInterval(auth_window_timer);
                            //window.location.reload();
                        }
                    } 
                };
            }, 500);
            $(".meeting_authorization").attr("disabled", false);
			//window.location.reload();


        });
    });

    /*Creating a Meeting Function*/
    $(document).on('submit', '.zoom-metting-form', function (e) {

        e.preventDefault();
        var this_value = $(this);
        var meetID = $(this).find("input[name=current_meeting_id]").val();
        var freelancer_id = $(this).find("input[name=current_author]").val();
        var project_id = $(this).find("input[name=current_job]").val();

        this_value.find('span.bubbles').addClass('view');
        $(".zoom-metting-form-btn").attr("disabled", true);
        var freelanceAjaxURL = $("#freelance_ajax_url").val();

        $.post(freelanceAjaxURL, {
            freelancer_id: freelancer_id,
            project_id: project_id,
            meetID: meetID,
            form_data: $(this).serialize(),
            action: 'exertio_setup_zoom_meeting',
        }).done(function (response) {
            $("#zoom_meeting_container").html(response);
            $(this).show();
            //var data = typeof response.data !== 'undefined' ? response.data : '';

            $('.zoom-meeting-popup').modal('hide');
            $(this).hide();
			$('.zoom-meeting-popup').hide();
			$('.zoom-metting-form-btn').attr("disabled", false);
			window.location.reload();
        });
    });

    /* Delete Meeting*/
    $("#meeting_deletion").on("click", function (e) {

        e.preventDefault();
        var this_value = $(this);
        var freelancer_id = $(this).attr('data-fl-id');
        var project_id = $(this).attr('data-pid');
        var meeting_id = $(this).attr('data-meetid');

        this_value.find('span.bubbles').addClass('view');
        $("#meeting_deletion").attr("disabled", true);
        var freelanceAjaxURL = $("#freelance_ajax_url").val();

        $.post(freelanceAjaxURL, {
            freelancer_id: freelancer_id,
            project_id: project_id,
            meeting_id: meeting_id,
            form_data: $(this).serialize(),

            action: 'exertio__zoom_delete_meet',
        }).done(function (response) {

            window.location.reload(true);

        });
    });




})(jQuery);