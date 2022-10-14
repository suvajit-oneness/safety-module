<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style = "border:2px solid black;">
    <h4 style = "color:red;text-align:center;">Lessons Learned from Incident Investigation</h4>
    <table style = "width:85vw;">
        <thead>

        </thead>
        <tbody>
            <tr>
                <td style = "border:1px solid black;text-align:left;padding:5px;">ID : {{$incident_report->id}}</td>
                <td style = "border:1px solid black;text-align:left;padding:5px;">{{$incident_report->incident_header}}</td>
            </tr> 
            <tr>
                <td style = "border:1px solid black;text-align:left;padding:5px;">Incident description : </td>
                <td style = "border:1px solid black;text-align:left;padding:5px;">{{$incident_report->incident_brief}}</td>
            </tr>
            <tr>
                <td style = "border:1px solid black;text-align:left;padding:5px;">Photos : </td>
                <td style = "border:1px solid black;text-align:center;"><center><img height="200" width="200" src="{{$incident_image}}" alt="" sizes="" srcset=""></center></td>
            </tr> 
            @if(!session('is_ship'))
                <tr>
                    <td style = "border:1px solid black;text-align:left;padding:5px;">Potential Outcome : </td>
                    <td style = "border:1px solid black;text-align:left;padding:5px;">{{$incident_report->potential_outcome}}</td>
                </tr>
            @endif
            <tr>
                <td style = "border:1px solid black;text-align:left;padding:5px;">Causes: </td>
                <td style = "border:1px solid black;text-align:left;padding:5px;"></td>
            </tr>
            <tr>
                <td style = "border:1px solid black;text-align:left;padding:5px;">Corrective/Preventive Actions: </td>
                <td style = "border:1px solid black;text-align:left;padding:5px;">
                    @if($incident_reports_preventive_actions)
                        {{$incident_reports_preventive_actions->primary}}<br>
                        {{$incident_reports_preventive_actions->secondary}}
                    @endif
                </td>
            </tr>
            @if(!session('is_ship'))
                <tr>
                    <td style = "border:1px solid black;background-color:red;text-align:left;padding:5px;">Key message: </td>
                    <td style = "border:1px solid black;text-align:left;padding:5px;">{{$incident_report->key_message}}</td>
                </tr>
                <tr>
                    <td style = "border:1px solid black;background-color:red;text-align:left;padding:5px;">Lessons Learned: </td>
                    <td style = "border:1px solid black;text-align:left;padding:5px;">{{$incident_report->lessons_learned}}</td>
                </tr>
            @endif
            <tr>
                <td style = "border:1px solid black;text-align:left;padding:5px;">Team engagement/discussion topics: </td>
                <td style = "border:1px solid black;text-align:left;padding:5px;">{{$incident_report->team_engagement_and_discussion_topic}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>