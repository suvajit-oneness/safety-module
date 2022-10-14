$('#hazards-name').on('change',function(){
    var selected_value = $(this).val();
    $.ajax({
        url:'/fetchRafData',
        type:"GET",
        data:{
                'id' : selected_value
            },	
        success:function(data){

            console.log(data);
            if(data<10){
                $('#reference').text('H-0'+selected_value+'.0'+data);     
            }
            else{
                $('#reference').text('H-0'+selected_value+'.'+data); 
            }            
            $('#reference_hidden').attr('value', data);
            // console.log(code);
        },
        error:function (err){
            console.log('error : ',err);
        }
    });	
});

$(".risk_select").change(function(){
    var color = $("option:selected", this).css( "background-color" );
    $(this).css("background-color", color);
});