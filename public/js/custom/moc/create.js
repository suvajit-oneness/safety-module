

var changeRequested = [];

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

var checklist_store = [];
$('.checkliststore').on('change', function () {
   
    //alert('in change requested'); 
    var key = $(this).attr('data-id');

    
    var value = $(this).val();

    
    
    console.log("Key ::"+key); // 1
    console.log("Value ::"+value); // qwerty

    // [{"key":"1","value":"qwerty"},{"key":"2","value":"def"}]

    var index;
    var isPresent = 0;

    for(var i = 0; i<checklist_store.length; i++){ // length = 2
        var eachchecklist_store = checklist_store[i];//{"key":"1","value":"abc"}
        if(eachchecklist_store.key == key){
            isPresent = 1;
            index = i;
            break;
        }
    }

    if(isPresent){
        checklist_store[index].value = value;
    }
  
    else{
        checklist_store.push({ 
            "key" : key,
            "value" : value
        });
    }

    console.log("Array after change :: ",checklist_store);

    $('#CHECKPAIRID').val(JSON.stringify(checklist_store));

    console.log("Hidden Dom element after change :: ",$('#CHECKPAIRID').val());
}); 

