

<!-- END CF Logic -->
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
<title>wpditto | contact form</title>
<!-- FAVICON AND APPLE TOUCH -->

    
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="sticky-header">
<div id="page-wrapper">
    <form id="frmContact" method="post" action="send.php">

        <div class="input_holder">
            <input class="col-xs-12" id="name" type="text" name="name" placeholder="Name" required>
        </div>
        <div class="input_holder">
            <input class="col-xs-12" id="email" type="text" name="email" placeholder="E-mail" required>
        </div>

        <div class="input_holder">
            <textarea class="col-xs-12" id="message" name="message" rows="8" cols="25" placeholder="Type your message here"></textarea>

        </div>

        <div class="input_holder">
            <div class="g-recaptcha" data-sitekey="your_site_key"></div>
        </div>
        <div class="input_holder">
            <div id="alert"></div>
            <div id="mail-status"></div>
        </div>



        <div class="input_holder">
            <input class="btn btn-default" id="submit" type="submit" name="submit" value="Submit">
        </div>

    </form>


    This form is design and build by <a href="https://www.wpditto.com/">www.wpditto.com/</a> Contact me with <a href="mailto:anrctg@gmail.com">Contact me with</a>

</div>
<!-- PAGE-WRAPPER -->

<!-- jQUERY -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<script>
    $('#frmContact').submit(function(event) {
        event.preventDefault(); // Prevent direct form submission
        $('#alert').text('Processing...').fadeIn(0); // Display "Processing" to let the user know that the form is being submitted
        var name = $("#name").val();
        var email = $("#email").val();
        var message = $("#message").val();
        $.ajax({
            url: 'send.php',
            type: 'post',
            data: {
                name: name,
                email: email,
                message: message,
                captcha: grecaptcha.getResponse()

            },
            dataType: 'json',
            success: function( _response ) {
                console.log(_response.type);
                // The Ajax request is a success. _response is a JSON object

                var type = _response.type;

                if (type == "error") {
                    // In case of error, display it to user

                    $('#alert').removeClass('success').addClass('error').fadeIn().html(_response.text);
                } else {
                    // In case of success, display it to user and remove the submit button
                    $('#alert').removeClass('error').addClass('success').fadeIn().html(_response.text);

                }

            },
            error: function(jqXhr, json, errorThrown){
                // In case of Ajax error too, display the result
                var error = jqXhr.responseText;
                $('#alert').html(error);
            }
        });
    });


</script>

</body>
</html>