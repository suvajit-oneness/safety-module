<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      table{
          border: 1px solid black;
        
      }
    </style>
</head>
<body>

{{-- Start --}}
   <table style="width:100%; padding: 23px">
       <tr  style="border-spacing: 10px">
           <th>
                <img src="C:\xampp\htdocs\SafetyModule-Shore\public\images\backgrounds\TCC Group Logo - high resolution.png" alt="logo" height='60' width='90' srcset="">
           </th>
           <td style=' border: 1px solid black ; margin: auto;'>
              <h4 style='text-align:center'> Immediate Accident Notification Report</h4> 
           </td>
       </tr> 
       <tr>
           <th style=' border: 1px solid black '>
              ID:{{$ID}}
           </th>
            <td style=' border: 1px solid black ; background-color: #656255;'>
            {{$incident_report->incident_header}}
            </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
               Date/time:{{$incident_report->date_of_incident}}{{$incident_report->time_of_incident_lt}}
           </th>
           <td rowspan='2' style=' border: 1px solid black ;  background-color: grey '>
                  {{$incident_report->incident_brief}}
           </td>
       </tr>
      
       <tr>
           <th style=' border: 1px solid black '>
              Location: {{$incident_reports_event_information->location_of_incident}}
           </th>
       </tr>
       <tr>
           <td rowspan='5' colspan='2' style=' border: 1px solid black ; background-color:#ffcccb; padding: 23px'>
               <h4>Immediate actions to be taken</h4>
               <p > {{$incident_report->Immediate_actions}}</p>
           </td>
       </tr>
        <tr>
            <th>
                
            </th>
        </tr>
        <tr>
            <th>

            </th>
        </tr>
        <tr>
            <th>

            </th>
        </tr>
        <tr>
            <th>

            </th>
        </tr>
        <tr>
            <td>
                 <img src="{{$incident_report->incident_image}}" alt="" height='200' width='300' srcset="">
            </td>
           
        </tr>
   </table>






{{-- End --}}

</body>
</html>