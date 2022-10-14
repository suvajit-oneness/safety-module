$(() => {


    /* MULTI SELECT INITIALIZATION FOR NON-CONFIRMITY */
    $('#rootcauses').multiselect();
    $('#dd3').multiselect();
    $('#ddd3').multiselect();

    $('#preventiveactions').multiselect();
    $('#dd4').multiselect();

    /* MULTI SELECT INITIALIZATION FOR OBSERVATION (prefix: obs_)*/
    $('#obs_rootcauses').multiselect();
    $('#obs_dd3').multiselect();
    $('#d_obs_dd3').multiselect();

    $('#obs_preventiveactions').multiselect();
    $('#obs_dd4').multiselect();

    /* MULTI SELECT INITIALIZATION FIR PSC (prefix:psc_)*/
    $('#psc_rootcauses').multiselect();
    $('#psc_dd3').multiselect();
    $('#psc_ddd3').multiselect();

    $('#psc_preventiveactions').multiselect();
    $('#psc_dd4').multiselect();

});





/* ... DROPDOWN VALUE FETCHNG FOR NON-CONFIRMITY STARTS FROM HERE ... */


$(() => {

    /*{{-- FETCHING SUB-DROPDOWN FOR NON-CONFIRMITY
    ============================================ --}}*/

    $("#preventiveactions").change(()=>{
        var e = $("#preventiveactions").val();
        var atr = $("#preventiveactions").attr("myid");


        if(  Array.isArray(e))
        {
            for(let i=0;i < e.length ; i++){

                subajaxmulti( e[i] , atr , i);
            }
            if(!e.length){subajaxmulti( 0 , atr , 0);}
        }
        else
        {
            subajax(e , atr)
        }
        setInterval(function(){ $('#dd4').multiselect('rebuild');}, 2000);

    })

    $("#rootcauses").change(()=>{
        var e = $("#rootcauses").val();
        var atr = $("#rootcauses").attr("myid");


        if(  Array.isArray(e))
        {
            for(let i=0;i < e.length ; i++){

                subajaxmulti( e[i] , atr , i);
            }
            if(!e.length){subajaxmulti( 0 , atr , 0);}

        }
        else
        {
            subajax(e , atr)
        }
        setInterval(function(){ $('#dd3').multiselect('rebuild');}, 2000);

    })





   /* {{-- FETCHING TER-DROPDOWN FOR NON-CONFIRMITY
    ============================================== --}}*/
    $(".droptwo").change(function(){
            var e = $(".droptwo:focus").val();
            var atr = $(".droptwo:focus").attr("myidtwo");

            if(  Array.isArray(e))
            {
                for(let i=0;i < e.length ; i++){

                    terajaxmulti( e[i] , atr , i);
                }
                if(!e.length){terajaxmulti( 0 , atr , 0);}

            }


    })



    $("#dd3").change(function(){
            var e = $("#dd3").val();
            var atr = $("#dd3").attr("myidtwo");

            if(  Array.isArray(e))
            {
                for(let i=0;i < e.length ; i++){

                    terajaxmulti( e[i] , atr , i);
                }
                if(!e.length){terajaxmulti( 0 , atr , 0);}

            }

            setInterval(function(){ $('#ddd3').multiselect('rebuild');}, 2000);
    })

});




/*
{{--  helper  --}}

{{--  ------------------------- -------- -------------------------------------  --}}
{{--  ------------------------- Sub ajax -------------------------------------  --}}
{{--  ------------------------- -------- -------------------------------------  --}}
*/
        function subajax( d , atr)
        {
            $.ajax({
                                    type: 'POST',
                                    url: "/api/subtype",
                                    data: {'id': d},
                                    success: function(result)
                                    {

                                                let output = ""
                                                if(result.length < 1)
                                                {
                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                    $("#display_d"+atr).css("cssText", "display: none !important;");
                                                    $("#"+atr).html("");
                                                    $("#d"+atr).html("");
                                                }
                                                else
                                                {
                                                    for(let i = 0; i < result.length; i++)
                                                    {
                                                        output += "<option value="+ result[i].type_sub_name +">"+ result[i].type_sub_name +"</option>";
                                                    }
                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                }

                                                document.getElementById(atr).innerHTML +=  output


                                    }
                        });
        }

        function subajaxmulti( d , atr , c)
        {
            $.ajax({
                                    type: 'POST',
                                    url: "/api/subtype",
                                    data: {'id': d},
                                    success: function(result)
                                    {

                                                let output = ""
                                                if(result.length < 1)
                                                {
                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                    $("#display_d"+atr).css("cssText", "display: none !important;");
                                                    $("#"+atr).html("");
                                                    $("#d"+atr).html("");
                                                }
                                                else
                                                {
                                                    for(let i = 0; i < result.length; i++)
                                                    {
                                                        output += "<option value="+ result[i].type_sub_name +">"+ result[i].type_sub_name +"</option>";
                                                    }
                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                }

                                                if(c == 0)
                                                {
                                                    document.getElementById(atr).innerHTML =output ;
                                                }
                                                else
                                                {
                                                    document.getElementById(atr).innerHTML +=output ;
                                                }

                                    }
                        });
        }
/*
{{--  --------------------- -------- ---------------------  --}}
{{--  --------------------- Ter ajax ---------------------  --}}
{{--  --------------------- -------- ---------------------  --}}
*/
        function terajax(f , atr)
        {
            $.ajax({
                    type: 'POST',
                    url: "/api/tertype",
                    data: {'id': f},
                    success: function(result)
                    {
                                let output = ""
                                if(result.length < 1){
                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                    $("#"+atr).html("");
                                }
                                else{
                                    for(let i = 0; i < result.length; i++)
                                    {
                                        output += "<option value="+ result[i].type_ter_name +">"+ result[i].type_ter_name +"</option>";
                                    }
                                    $("#display_"+atr).css("cssText", "display: block !important;");;
                                }
                                document.getElementById(atr).innerHTML += output;

                    }
            });
        }

        function terajaxmulti(f , atr , c)
        {
            $.ajax({
                                type: 'POST',
                                url: "/api/tertype",
                                data: {'id': f},
                                success: function(result)
                                {

                                            let output = ""
                                            if(result.length < 1)
                                            {
                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                $("#"+atr).html("");
                                            }
                                            else
                                            {
                                                for(let i = 0; i < result.length; i++)
                                                {
                                                    output += "<option value="+ result[i].type_ter_name +">"+ result[i].type_ter_name +"</option>";
                                                }
                                                $("#display_"+atr).css("cssText", "display: block !important;");;
                                            }

                                            if(c == 0)
                                            {
                                                document.getElementById(atr).innerHTML = output;
                                            }
                                            else
                                            {
                                                document.getElementById(atr).innerHTML += output;
                                            }

                                }
                    });
        }

/* {{--  --------------------- Ter ajax ---------------------  --}} */





                    /* ... DROPDOWN VALUE FETCHNG FOR OBSERVATION STARTS FROM HERE ... */

$(() => {

    /*{{-- FETCHING SUB-DROPDOWN FOR OBSERVATION
    ============================================ --}}*/


    $("#obs_preventiveactions").change(()=>{
        var e = $("#obs_preventiveactions").val();
        var atr = $("#obs_preventiveactions").attr("myid");

        if(  Array.isArray(e))
        {
            for(let i=0;i < e.length ; i++){
                obs_subajaxmulti( e[i] , atr , i);
            }
            if(!e.length){obs_subajaxmulti( 0 , atr , 0);}
        }
        else
        {
            obs_subajax(e , atr)
        }
        setInterval(function(){ $('#obs_dd4').multiselect('rebuild');}, 2000);

    })

    $("#obs_rootcauses").change(()=>{
        var e = $("#obs_rootcauses").val();
        var atr = $("#obs_rootcauses").attr("myid");


        if(  Array.isArray(e))
        {
            for(let i=0;i < e.length ; i++){

                obs_subajaxmulti( e[i] , atr , i);
            }
            if(!e.length){obs_subajaxmulti( 0 , atr , 0);}
        }
        else
        {
            obs_subajax(e , atr)
        }
        setInterval(function(){ $('#obs_dd3').multiselect('rebuild');}, 2000);

    })





   /* {{-- FETCHING TER-DROPDOWN FOR OBSERVATION
    ============================================== --}}*/
    $(".droptwo").change(function(){
            var e = $(".droptwo:focus").val();
            var atr = $(".droptwo:focus").attr("myidtwo");

            if(  Array.isArray(e))
            {
                for(let i=0;i < e.length ; i++){

                    obs_terajaxmulti( e[i] , atr , i);
                }
                if(!e.length){obs_terajaxmulti( 0 , atr , 0);}
            }


    })



    $("#obs_dd3").change(function(){
            var e = $("#obs_dd3").val();
            var atr = $("#obs_dd3").attr("myidtwo");
            if(  Array.isArray(e))
            {
                for(let i=0;i < e.length ; i++){

                    obs_terajaxmulti( e[i] , atr , i);
                }
                if(!e.length){obs_terajaxmulti( 0 , atr , 0);}
            }

            setInterval(function(){ $('#d_obs_dd3').multiselect('rebuild');}, 2000);
    })

});




/*
{{--  helper  --}}

{{--  ------------------------- -------- -------------------------------------  --}}
{{--  ------------------------- Sub ajax -------------------------------------  --}}
{{--  ------------------------- -------- -------------------------------------  --}}
*/
        function obs_subajax( d , atr)
        {
            $.ajax({
                                    type: 'POST',
                                    url: "/api/subtype",
                                    data: {'id': d},
                                    success: function(result)
                                    {
                                                let output = ""
                                                if(result.length < 1)
                                                {
                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                    $("#display_d_"+atr).css("cssText", "display: none !important;");
                                                    $("#"+atr).html("");
                                                    $("#d"+atr).html("");
                                                }
                                                else
                                                {
                                                    for(let i = 0; i < result.length; i++)
                                                    {
                                                        output += "<option value="+ result[i].type_sub_name +">"+ result[i].type_sub_name +"</option>";
                                                    }
                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                }

                                                document.getElementById(atr).innerHTML +=  output


                                    }
                        });
        }

        function obs_subajaxmulti( d , atr , c)
        {
            $.ajax({
                                    type: 'POST',
                                    url: "/api/subtype",
                                    data: {'id': d},
                                    success: function(result)
                                    {
                                                let output = ""
                                                if(result.length < 1)
                                                {
                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                    $("#display_d_"+atr).css("cssText", "display: none !important;");
                                                    $("#"+atr).html("");
                                                    $("#d"+atr).html("");
                                                }
                                                else
                                                {
                                                    for(let i = 0; i < result.length; i++)
                                                    {
                                                        output += "<option value="+ result[i].type_sub_name +">"+ result[i].type_sub_name +"</option>";
                                                    }
                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                }

                                                if(c == 0)
                                                {
                                                    document.getElementById(atr).innerHTML =output ;
                                                }
                                                else
                                                {
                                                    document.getElementById(atr).innerHTML +=output ;
                                                }

                                    }
                        });
        }
/*
{{--  --------------------- -------- ---------------------  --}}
{{--  --------------------- Ter ajax ---------------------  --}}
{{--  --------------------- -------- ---------------------  --}}
*/
        function obs_terajax(f , atr)
        {
            $.ajax({
                    type: 'POST',
                    url: "/api/tertype",
                    data: {'id': f},
                    success: function(result)
                    {
                                let output = ""
                                if(result.length < 1){
                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                    $("#"+atr).html("");
                                }
                                else{
                                    for(let i = 0; i < result.length; i++)
                                    {
                                        output += "<option value="+ result[i].type_ter_name +">"+ result[i].type_ter_name +"</option>";
                                    }
                                    $("#display_"+atr).css("cssText", "display: block !important;");;
                                }
                                document.getElementById(atr).innerHTML += output;

                    }
            });
        }

        function obs_terajaxmulti(f , atr , c)
        {
            $.ajax({
                                type: 'POST',
                                url: "/api/tertype",
                                data: {'id': f},
                                success: function(result)
                                {
                                            let output = ""
                                            if(result.length < 1)
                                            {
                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                $("#"+atr).html("");
                                            }
                                            else
                                            {
                                                for(let i = 0; i < result.length; i++)
                                                {
                                                    output += "<option value="+ result[i].type_ter_name +">"+ result[i].type_ter_name +"</option>";
                                                }
                                                $("#display_"+atr).css("cssText", "display: block !important;");;
                                            }

                                            if(c == 0)
                                            {
                                                document.getElementById(atr).innerHTML = output;
                                            }
                                            else
                                            {
                                                document.getElementById(atr).innerHTML += output;
                                            }

                                }
                    });
        }

/* {{--  --------------------- Ter ajax ---------------------  --}} */






                                        /* ... DROPDOWN VALUE FETCHNG FOR PSC STARTS FROM HERE ... */
$(() => {

    /*{{-- FETCHING SUB-DROPDOWN FOR PSC
    ============================================ --}}*/


    $("#psc_preventiveactions").change(()=>{
        var e = $("#psc_preventiveactions").val();
        var atr = $("#psc_preventiveactions").attr("myid");

        if(  Array.isArray(e))
        {
            for(let i=0;i < e.length ; i++){
                psc_subajaxmulti( e[i] , atr , i);
            }
            if(!e.length){psc_subajaxmulti( 0 , atr , 0);}
        }
        else
        {
            psc_subajax(e , atr)
        }
        setInterval(function(){ $('#psc_dd4').multiselect('rebuild');}, 2000);

    })

    $("#psc_rootcauses").change(()=>{
        var e = $("#psc_rootcauses").val();
        var atr = $("#psc_rootcauses").attr("myid");


        if(  Array.isArray(e))
        {
            for(let i=0;i < e.length ; i++){

                psc_subajaxmulti( e[i] , atr , i);
            }
            if(!e.length){psc_subajaxmulti( 0 , atr , 0);}
        }
        else
        {
            psc_subajax(e , atr)
        }
        setInterval(function(){ $('#psc_dd3').multiselect('rebuild');}, 2000);

    })





   /* {{-- FETCHING TER-DROPDOWN FOR PSC
    ============================================== --}}*/
    $(".droptwo").change(function(){
            var e = $(".droptwo:focus").val();
            var atr = $(".droptwo:focus").attr("myidtwo");

            if(  Array.isArray(e))
            {
                for(let i=0;i < e.length ; i++){

                    psc_terajaxmulti( e[i] , atr , i);
                }
                if(!e.length){psc_terajaxmulti( 0 , atr , 0);}
            }


    })



    $("#psc_dd3").change(function(){
            var e = $("#psc_dd3").val();
            var atr = $("#psc_dd3").attr("myidtwo");
            if(  Array.isArray(e))
            {
                for(let i=0;i < e.length ; i++){

                    psc_terajaxmulti( e[i] , atr , i);
                }
                if(!e.length){psc_terajaxmulti( 0 , atr , 0);}
            }

            setInterval(function(){ $('#d_psc_dd3').multiselect('rebuild');}, 2000);
    })

});




/*
{{--  helper  --}}

{{--  ------------------------- -------- -------------------------------------  --}}
{{--  ------------------------- Sub ajax -------------------------------------  --}}
{{--  ------------------------- -------- -------------------------------------  --}}
*/
        function psc_subajax( d , atr)
        {
            $.ajax({
                                    type: 'POST',
                                    url: "/api/subtype",
                                    data: {'id': d},
                                    success: function(result)
                                    {
                                                let output = ""
                                                if(result.length < 1)
                                                {
                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                    $("#display_d_"+atr).css("cssText", "display: none !important;");
                                                    $("#"+atr).html("");
                                                    $("#d"+atr).html("");
                                                }
                                                else
                                                {
                                                    for(let i = 0; i < result.length; i++)
                                                    {
                                                        output += "<option value="+ result[i].type_sub_name +">"+ result[i].type_sub_name +"</option>";
                                                    }
                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                }

                                                document.getElementById(atr).innerHTML +=  output


                                    }
                        });
        }

        function psc_subajaxmulti( d , atr , c)
        {
            $.ajax({
                                    type: 'POST',
                                    url: "/api/subtype",
                                    data: {'id': d},
                                    success: function(result)
                                    {
                                                let output = ""
                                                if(result.length < 1)
                                                {
                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                    $("#display_d_"+atr).css("cssText", "display: none !important;");
                                                    $("#"+atr).html("");
                                                    $("#d"+atr).html("");
                                                }
                                                else
                                                {
                                                    for(let i = 0; i < result.length; i++)
                                                    {
                                                        output += "<option value="+ result[i].type_sub_name +">"+ result[i].type_sub_name +"</option>";
                                                    }
                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                }

                                                if(c == 0)
                                                {
                                                    document.getElementById(atr).innerHTML =output ;
                                                }
                                                else
                                                {
                                                    document.getElementById(atr).innerHTML +=output ;
                                                }

                                    }
                        });
        }
/*
{{--  --------------------- -------- ---------------------  --}}
{{--  --------------------- Ter ajax ---------------------  --}}
{{--  --------------------- -------- ---------------------  --}}
*/
        function psc_terajax(f , atr)
        {
            $.ajax({
                    type: 'POST',
                    url: "/api/tertype",
                    data: {'id': f},
                    success: function(result)
                    {
                                let output = ""
                                if(result.length < 1){
                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                    $("#"+atr).html("");
                                }
                                else{
                                    for(let i = 0; i < result.length; i++)
                                    {
                                        output += "<option value="+ result[i].type_ter_name +">"+ result[i].type_ter_name +"</option>";
                                    }
                                    $("#display_"+atr).css("cssText", "display: block !important;");;
                                }
                                document.getElementById(atr).innerHTML += output;

                    }
            });
        }

        function psc_terajaxmulti(f , atr , c)
        {
            $.ajax({
                                type: 'POST',
                                url: "/api/tertype",
                                data: {'id': f},
                                success: function(result)
                                {
                                            let output = ""
                                            if(result.length < 1)
                                            {
                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                $("#"+atr).html("");
                                            }
                                            else
                                            {
                                                for(let i = 0; i < result.length; i++)
                                                {
                                                    output += "<option value="+ result[i].type_ter_name +">"+ result[i].type_ter_name +"</option>";
                                                }
                                                $("#display_"+atr).css("cssText", "display: block !important;");;
                                            }

                                            if(c == 0)
                                            {
                                                document.getElementById(atr).innerHTML = output;
                                            }
                                            else
                                            {
                                                document.getElementById(atr).innerHTML += output;
                                            }

                                }
                    });
        }

/* {{--  --------------------- Ter ajax ---------------------  --}} */
