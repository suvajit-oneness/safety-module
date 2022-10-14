// $(document).ready(function() {
//     toastr.options = {
//         'closeButton': true,
//         'debug': false,
//         'newestOnTop': false,
//         'progressBar': false,
//         'positionClass': 'toast-top-right',
//         'preventDuplicates': false,
//         'showDuration': '1000',
//         'hideDuration': '1000',
//         'timeOut': '5000',
//         'extendedTimeOut': '90000',
//         'showEasing': 'swing',
//         'hideEasing': 'linear',
//         'showMethod': 'fadeIn',
//         'hideMethod': 'fadeOut',
//     }
// });
$(function () {
    var status = parseInt($("body").data("status"));

    switch (status) {
        case 0 :
            toastr.error('Unsuccessful');
            break;
        case 1 :
            toastr.success('Data submitted successfully');
            break;      
        case 2:
            toastr.success('Data updated successfully');
            break; 
        case 3:
            toastr.success('Data deleted successfully');
            break;
        case 4:
            toastr.error('No data available');
            break;       
    }
});
