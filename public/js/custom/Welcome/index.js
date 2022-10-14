$(document).ready(function(){
    // console.log(vessel_details);
    // console.log(vessel_details['vessel_image']);
    // console.log(vessel_details.vessel_image);
    if(vessel_details && vessel_details['vessel_image']){
        var img = vessel_details['vessel_image'];
        $('#img').css({'background':`url("${img}") `});
        $('#img').css({'background-size':`100% 100%`});    
    }   
    else{
        $('#img').css({'background':`url("/images/backgrounds/ship-in-sea.jpg") `});
        $('#img').css({'background-size':`100% 100%`});    
    } 
});