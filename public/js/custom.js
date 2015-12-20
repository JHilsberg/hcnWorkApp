$("#success-alert").ready (function(){
    $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
        $("#success-alert").alert('close');
    });
});
