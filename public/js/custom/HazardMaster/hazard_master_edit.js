$(".risk_select").change(function(){
    var color = $("option:selected", this).css( "background-color" );
    $(this).css("background-color", color);
});