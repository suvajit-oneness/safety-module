<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style = "">
    <table style = "width:85vw;border:3px solid black;margin:20px;">
        <thead>

        </thead>
        <tbody>
            <tr>
                <th colspan = "1" style = "border:1px solid black;color:blue;text-align:center;padding:5px;"><img src="{{ public_path('images/TCCflagwithoutbackground.png') }}" height="50px" width='50px'  ></th>
                <td colspan = "3" style = "border:1px solid black;text-align:center;"><h4>Immediate Incident Notification Report</h4> <h5 style = "color:red;padding:5px;">Title – {{$incident_report->incident_header}}</h5></td>
            </tr>
            <tr>
                <td colspan = "1" style = "border:1px solid black;color:black;text-align:left;padding:5px;">ID : {{$incident_report->id}}</td>
                <td colspan = "3" style = "border:1px solid black;color:black;text-align:left;background-color:rgb(91, 154, 150);padding:5px;">Incident categorisation: {{$categorisation}}</td>
            </tr>
            <tr>
                <td colspan = "1" style = "border:1px solid black;color:black;text-align:left;padding:5px;">Date/time : {{$incident_report->date_of_incident}}/{{$incident_report->time_of_incident_lt}}</td>
                <td colspan = "3" rowspan = "3"style = "border:1px solid black;color:black;text-align:left;background-color: rgb(198, 206, 213);padding:5px;">Incident description : {{$incident_report->incident_brief}}</td>
            </tr>
            <tr>
                <td colspan = "1" style = "border:1px solid black;color:black;text-align:left;padding:5px;">Activity : {{$activity}}</td>
            </tr>
            <tr>
                <td colspan = "1" style = "border:1px solid black;color:black;text-align:left;padding:5px;">Location : {{$incident_event->location_of_incident}}</td>
            </tr>
            <tr>
                <td colspan = "4" style = "border:1px solid black;color:black;text-align:left;background-color:pink;padding:5px;">Immediate action to be taken :<br> {{$incident_report->Immediate_action_to_be_taken}}</td>
            </tr>
            <tr>
                <td colspan = "4" style = "border:1px solid black;color:black;text-align:left;">
                    <center><img height="200" width="200" src="{{$incident_image}}" alt="" sizes="" srcset=""></center>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>