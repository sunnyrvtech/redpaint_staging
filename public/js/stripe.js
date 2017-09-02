jQuery(function ($) {
    Stripe.setPublishableKey("pk_test_d3ObrGKby4X9MxxwIfXaiJw7");
    $('#subscription-form').submit(function (event) {
        var form = $(this);
        // Disable the submit button to prevent repeated clicks
        form.find('button').attr('disabled', 'disabled').text('Just one moment..');
        var plan = $("#plan").val();
        if (plan != '') {
            Stripe.card.createToken(form, stripeResponseHandler);
            // Prevent the form from submitting with the default action
        } else {
            form.find('.payment-errors').text("Please choose subscription plan");
            form.find('button').prop('disabled', false);
            form.find('button').text('Subscribe');
        }
        return false;
    });
});
function stripeResponseHandler(status, response) {
    var form = $('#subscription-form');

    if (response.error) {
        // Show the errors on the form
        form.find('.payment-errors').text(response.error.message);
        form.find('button').prop('disabled', false);
        form.find('button').text('Subscribe');
    } else {
        // response contains id and card, which contains additional card details
        console.log(response.id);
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and submit
        form.get(0).submit();
    }
}
;
