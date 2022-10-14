var changeRequested = [];
$(document).ready(function () {
        var key = $('.change_requested').attr('data-id');

        var value = $('.change_requested').val();
    
        console.log("Key ::"+key); // 1
        console.log("Value ::"+value); // qwerty
        var index;
        var isPresent = 0;
    
        for(var i = 0; i<changeRequested.length; i++){ // length = 2
            var eachChangeRequest = changeRequested[i];//{"key":"1","value":"abc"}
            if(eachChangeRequest.key == key){
                isPresent = 1;
                index = i;
                break;
            }
        }
        if(isPresent){
            changeRequested[index].value = value;
        }
        else{
            changeRequested.push({ 
                "key" : key,
                "value" : value
            });
        }
        console.log("Array after change :: ",changeRequested);
        $('#STM_hidden').val(JSON.stringify(changeRequested));
        console.log("Hidden Dom element after change :: ",$('#STM_hidden').val());
    
});
//  $('.change_requested').on('load',function () {
//     var key = $(this).attr('data-id');

//     var value = $(this).val();

//     console.log("Key ::"+key); // 1
//     console.log("Value ::"+value); // qwerty
//     var index;
//     var isPresent = 0;

//     for(var i = 0; i<changeRequested.length; i++){ // length = 2
//         var eachChangeRequest = changeRequested[i];//{"key":"1","value":"abc"}
//         if(eachChangeRequest.key == key){
//             isPresent = 1;
//             index = i;
//             break;
//         }
//     }
//     if(isPresent){
//         changeRequested[index].value = value;
//     }
//     else{
//         changeRequested.push({ 
//             "key" : key,
//             "value" : value
//         });
//     }
//     console.log("Array after change :: ",changeRequested);
//     $('#STM_hidden').val(JSON.stringify(changeRequested));
//     console.log("Hidden Dom element after change :: ",$('#STM_hidden').val());

// }); 

$('.change_requested').on('change', function () {
    
    //alert('in change requested'); 
    var key = $(this).attr('data-id');

    
    var value = $(this).val();

    
    
    console.log("Key ::"+key); // 1
    console.log("Value ::"+value); // qwerty

    // [{"key":"1","value":"qwegrty"},{"key":"2","value":"def"}]

    var index;
    var isPresent = 0;

    for(var i = 0; i<changeRequested.length; i++){ // length = 2
        var eachChangeRequest = changeRequested[i];//{"key":"1","value":"abc"}
        if(eachChangeRequest.key == key){
            isPresent = 1;
            index = i;
            break;
        }
    }
    
    if(isPresent){
        changeRequested[index].value = value;
    }
  
    else{
        changeRequested.push({ 
            "key" : key,
            "value" : value
        });
    }

    console.log("Array after change :: ",changeRequested);

    $('#STM_hidden').val(JSON.stringify(changeRequested));

    console.log("Hidden Dom element after change :: ",$('#STM_hidden').val());
}); 


