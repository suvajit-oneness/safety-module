$(document).ready(function () {
    
    // Apply the search
    // Setup - add a text input to each footer cell
    $("#hazard_master_table tfoot th").each(function () {
        var title = $(this).text();
        $(this).html(
            '<input type="text" placeholder="Search ' + title + '" />'
        );
    });
    // DataTable
    var table = $("#hazard_master_table").DataTable({
        initComplete: function () {
            // for keeping search bar at the thead
            var r = $('#hazard_master_table tfoot tr');
            r.find('th').each(function(){
                $(this).css('padding', 8);
            });
            $('#hazard_master_table thead').append(r);
            $('#search_0').css('text-align', 'center');
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;

                    $("input", this.footer()).on(
                        "keyup change clear",
                        function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        }
                    );
                });
        },
        // initComplete: function ()
        // {
        //     var r = $('#hazard_master_table tfoot tr');
        //     r.find('th').each(function(){
        //         $(this).css('padding', 8);
        //     });
        //     $('#hazard_master_table thead').append(r);
        //     $('#search_0').css('text-align', 'center');
        // },
    });
    // for shifting searchbox at top
   
});

function toggleExpansion(ele) {
    if ($(ele).parent().hasClass("showMore")) {
        showMore(ele);
    } else if ($(ele).parent().hasClass("showLess")) {
        showLess(ele);
    }
}
function showMore(ele) {
    //alert("show more")
    var td = $(ele).parent();
    var id = $(td).attr("data-id");
    var field = $(td).attr("data-field");
    var allText = hazardMasters.filter((sj) => sj.id == id);

    allText = allText[0][field];
    allText +=
        '<br><a style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show Less</a>';

    $(td).removeClass("showMore");
    $(td).addClass("showLess");
    //console.log(allText[0][field]);
    $(td).html(allText);
}

function showLess(ele) {
    //alert('show less');
    var td = $(ele).parent();
    var id = $(td).attr("data-id");
    var field = $(td).attr("data-field");

    /* console.log(td);
    console.log(id);
    console.log(field);*/
    //console.log(hazardMasters[field]);

    var allText = hazardMasters.filter((sj) => sj.id == id);
    allText = allText[0][field];

    var limitedText = allText.substring(0, stringLimit);

    limitedText +=
        '<br><a style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>';

    $(td).removeClass("showLess");
    $(td).addClass("showMore");
    //console.log(allText[0][field]);
    $(td).html(limitedText);
}
