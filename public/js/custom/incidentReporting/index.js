var drawer = null;

$(document).ready(function () {


    

    // Load Drawer js acording edit or create .....
    if (is_edited === '1')
    {
        $('#incidentPicUpdate').removeClass('d-none');
        console.log('Image ::',incident_image);
        if(incident_image == null || incident_image == undefined || incident_image == "" ){
            incident_image = '/images/drawer.jpg';
        }
        drawer = new DrawerJs.Drawer(null, {
            texts: customLocalization,
            plugins: drawerPlugins,
            defaultImageUrl: `${incident_image}`,
            // defaultImageUrl: '/images/drawer.jpg',
            defaultActivePlugin: { name: 'Pencil', mode: 'lastUsed' },
            basePath: '/drawerJs'
        }, 500, 700);
        $('#canvas-editor').append(drawer.getHtml());
        // $('#editable-canvas-image').
        drawer.onInsert();

        // drawer.api.setBackgroundImage(imgEl, options);

        // console.log("Serialised image data from db : ",incident_image_data);

        // if(incident_image_data){
        //     console.log("In imageData if : ");

        //     drawer.api.startEditing();
        //     drawer.api.loadCanvasFromData(incident_image_data);
        //     drawer.api.stopEditing();    
        // }        

        

        // options.scaleDownLargeImage = false;
        // options.centerImage = true;
              
        // if (!options.scaleDownLargeImage) {
        //     options.left = left;
        //     options.top = top;
        //     options.scaleX = scaleX;
        //     options.scaleY = scaleY;
        // };

        // drawer.api.setBackgroundImage(imgEl, options);        

        var imgSrc = `${incident_image}`;
        // console.log("Image to be loaded : ",incident_image);

        drawer.api.startEditing();


        var options = {};

        // var imgEl = 'img src="https://cdn.britannica.com/84/73184-004-E5A450B5/Sunflower-field-Fargo-North-Dakota.jpg"';
        // var options = {};
        // drawer.api.setBackgroundImage(imgEl, options);
        
        drawer.api.addImageFromUrl(imgSrc, options);

        // var updateOptions = {defaultImageUrl: `${incident_image}`};
        // drawer.api.updateOptions(updateOptions);

        // url = 'https://cdn.britannica.com/84/73184-004-E5A450B5/Sunflower-field-Fargo-North-Dakota.jpg'; 
        // drawer.api.setInactiveDrawerImage(url);
        // url = 'https://cdn.britannica.com/84/73184-004-E5A450B5/Sunflower-field-Fargo-North-Dakota.jpg'; 
        // image = new Image();
        // image.onload = function(){
        //     drawer.api.setInactiveDrawerImage(image);
        // };
        // image.src = url;
        drawer.api.stopEditing();
    } else {
        drawer = new DrawerJs.Drawer(null, {
            texts: customLocalization,
            plugins: drawerPlugins,
            defaultImageUrl: '/images/drawer.jpg',
            defaultActivePlugin: { name: 'Pencil', mode: 'lastUsed' },
            basePath: '/drawerJs'
        }, 500, 700);
        $('#canvas-editor').append(drawer.getHtml());
        drawer.onInsert();
    }
        
    
});

function loadImage(){
    var imgSrc = `${incident_image}`;
    // console.log("Image to be loaded : ",incident_image);

    drawer.api.startEditing();


    var options = {};

    // var imgEl = 'img src="https://cdn.britannica.com/84/73184-004-E5A450B5/Sunflower-field-Fargo-North-Dakota.jpg"';
    // var options = {};
    // drawer.api.setBackgroundImage(imgEl, options);

    drawer.api.addImageFromUrl(imgSrc, options);

    // var updateOptions = {defaultImageUrl: `${incident_image}`};
    // drawer.api.updateOptions(updateOptions);

    // url = 'https://cdn.britannica.com/84/73184-004-E5A450B5/Sunflower-field-Fargo-North-Dakota.jpg'; 
    // drawer.api.setInactiveDrawerImage(url);
    drawer.api.stopEditing();
    // $('#canvas-editor').click();

    // var drawerPlugins = [
    //     'Pencil',
    //     'Eraser',
    //     'Text',
    //     'ShapeContextMenu'
    // ];
    // var options = {plugins: drawerPlugins};
    // drawer.api.updateOptions(options);

    // $('#editable-canvas-image').click();
}
// Saving image html in an input element
var saveContent = function() {
    var html = $('#canvas-editor').html();
    $('#imageTextInput').val(html);
};

// Converting image to base64 format
var convertToImage = function(){
    var image = null;
    if(drawer){
        image = drawer.api.getCanvasAsImage(); 
    }
    return image;
}

// Downloading the image to file
var downloadImage = function(){
    var image = convertToImage();
    if(image){
        download(image, "SafetyModule.png", "image/png"); // function from downloadJs
    }
    else{
        console.log('Error in converting canvas to image');
    }    
}

// Setting image to input element
var setToInput = async function(){
    var image = convertToImage();
    if(image){
        $('#imageEncodedInput').val(image);
        // await setSerialisedData();
    }
    else{
        console.log('Error in converting canvas to image');
    }  
    return true;
}

var setSerialisedData = async function(){
    try{
        // console.log(drawer);
        if(drawer){
            drawer.api.startEditing();
            var serializedCanvasData = drawer.api.getCanvasAsJSON();
            drawer.api.stopEditing();   
            console.log('serializedCanvasData : ',serializedCanvasData); 
            // console.log('serializedCanvasData type : ',typeof serializedCanvasData); 
            $('#imageSerialisedInput').val(JSON.stringify(serializedCanvasData));            
        }        
    }
    catch(err){
        console.log("Could not serialize data : ",err)
    }
}