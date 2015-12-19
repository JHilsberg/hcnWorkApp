$("#success-alert").ready (function(){
    $("#success-alert").fadeTo(3500, 500).slideUp(500, function(){
        $("#success-alert").alert('close');
    });
});
