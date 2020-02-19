//On input field change execute function
$(document).on('change','#input-email', function (e) {
    //Setup csrf for ajax request
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //Get the email in input field
    var email = $('#input-email').val();
    //prevent default form submission
    e.preventDefault();
    //Create post request with data and get back the results
    $.ajax({
        method: "POST",
        url: "check-email",
        data: {
            "email": email
        }
    }).done(function( msg ) {
       //If user exists switch classes so that the error is shown
       if(msg.user === true) {
            $('#js-email-taken').addClass('d-box').removeClass('d-none');
       } else {
       //Else remove the error span box
           $('#js-email-taken').removeClass('d-box').addClass('d-none');
       }
    });
});
