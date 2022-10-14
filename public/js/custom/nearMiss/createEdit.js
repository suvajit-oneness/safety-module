var currentTab = 0; // Current tab is set to be the first tab (0)

$(document).ready(function () {
    console.log("ready!");
    showTab(currentTab); // Display the current tab

});

//  date-picker script for date field
$( "#date" ).datepicker({maxDate: new Date()});

// Event Handlers Start
        // fire next on presing enter
        $(document).on("keypress", function (e) {
            //all the action
            var key = e.which;
            if (key == 13) {
                nextPrev(1);
            }
        });
    // auto save start
        // step0 next button click
        $('[name = "step0" ]').click(() => {
            // alert('Hey i am in step0');
            var Data = new FormData();
            Data.append("id", $("#id").val());
            Data.append("date", $("#date").val());
            Data.append("description", $("#desc").val());
            Data.append("severity", $("#IIARCF_safety_Severity").find(':selected').val());
            Data.append("likelihood", $("#IIARCF_safety_Likelihood").find(':selected').val());
            Data.append("result", $("#IIARCF_safety_Result").val());
            Data.append("step", 0);
            // console.log(Data.id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "/api/nearMissAutoSave",
                method: "POST",
                contentType: false,
                processData: false,
                data: Data,
                dataType: "JSON",
            });
        });
        // step1 next button click
        $('[name = "step1" ]').click(() => {
            // alert('Hey i am in step1');
            var Data = new FormData();
            Data.append("id", $("#id").val());

            Data.append("incident_1", $("#incidenttype").val());
            Data.append("incident_2", $("#dd1").val());
            Data.append("incident_3", $("#ddd1").val());
            Data.append("corrective_action", $("#corrective_action").val());
            Data.append("step", 1);
            // corrective_action
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "/api/nearMissAutoSave",
                method: "POST",
                contentType: false,
                processData: false,
                data: Data,
                dataType: "JSON",
                // success: (result) => {
                //     Prefiller.PrefillSecondStep(result)
                //     toastr.success('Non Confirmity Submitted Successfully !!');
                // }
            });
        });
        // step2 next button click
        $('[name = "step2" ]').click(() => {
            // alert('Hey i am in step2');
            var Data = new FormData();
            Data.append("id", $("#id").val());

            Data.append("immediate_1", $("#immediatecause").val());
            Data.append("immediate_2", $("#dd2").val());
            Data.append("immediate_3", $("#ddd2").val());
            Data.append("step", 2);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "/api/nearMissAutoSave",
                method: "POST",
                contentType: false,
                processData: false,
                data: Data,
                dataType: "JSON",
            });
        });
        // step3 next button click
        $('[name = "step3" ]').click(() => {
            // alert('Hey i am in step3');
            var Data = new FormData();
            Data.append("id", $("#id").val());
            Data.append("root1", $("#rootcauses").val());
            Data.append("root2", $("#dd3").val());
            Data.append("root3", $("#ddd3").val());
            Data.append("step", 3);
            // console.log(Data);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "/api/nearMissAutoSave",
                method: "POST",
                contentType: false,
                processData: false,
                data: Data,
                dataType: "JSON",
            });
        });

        // step4 next button click
        $('[name = "step4" ]').click(() => {
            // alert('Hey i am in step4');
            var Data = new FormData();
            Data.append("id", $("#id").val());
            Data.append("prevent1", $("#preventiveactions").val());
            Data.append("prevent2", $("#dd4").val());
            Data.append("prevent3", $("#ddd4").val());
            Data.append("Note", $("#preventive_note").val());
            Data.append("step", 4);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "/api/nearMissAutoSave",
                method: "POST",
                contentType: false,
                processData: false,
                data: Data,
                dataType: "JSON",
            });
        });
    // auto save end
    // show result on change of severity
        $('#IIARCF_safety_Severity').on('change',() => {
            let r;
            let s = $('#IIARCF_safety_Severity').val();
            let l = $('#IIARCF_safety_Likelihood').val();
            r = s*l;
            $('#IIARCF_safety_Result').val(r);
        });
// Event Handlers End

// This function will display the specified tab of the form ...
    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == x.length - 1) {
            document.getElementById("nextBtn").innerHTML = "Submit Report";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        // ... and run a function that displays the correct step indicator:
        // fixStepIndicator(n)
    }

    function nextPrev(n) {
        console.log('clicked');
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1) {
            if (
                (n == 1 && !validateForm()) ||
                !validateFormTextarea() ||
                !validateFormSelect()
            )
                return false;
        }

        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :

        if (currentTab >= x.length) {
            //...the form gets submitted:
            document.getElementById("near_miss_form").submit();
            return false;
        }

        // Otherwise, display the correct tab:
        showTab(currentTab);
    }
    // This function deals with validation of the form fields
    function validateForm() {

        var x,
            y,
            i,
            valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // console.log(y.length);
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // console.log('form invalid');
                // and set the current valid status to false:
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className +=
                " finish";
        }
        return valid; // return the valid status
    }

    function validateFormTextarea() {
        // This function deals with validation of the form fields
        var x,
            y,
            i,
            valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("textarea");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // console.log('Textarea invalid');
                // and set the current valid status to false:
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className +=
                " finish";
        }
        return valid; // return the valid status
    }

    function validateFormSelect() {
        // This function deals with validation of the form fields

        var x,
            y,
            i,
            valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("select");
        if (y[0] != undefined) {
            // A loop that checks every input field in the current tab:

            // If a field is empty...
            if (y[0].value == 0) {
                // add an "invalid" class to the field:
                y[0].className += " invalid";
                // and set the current valid status to false:
                valid = false;
                // console.log('invalid form select');
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className +=
                    " finish";
            }
        }

        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i,
            x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }


