

<table style="width:100%; padding: 23px ; border: 1px solid black;">
    <caption style='color: red'><h1>Lessons Learned From Investigation</h1></caption>
       <tr>
           <th style=' border: 1px solid black '>
              ID:{{$ID}}
           </th>
           <td style=' border: 1px solid black '>
                {{$incident_report->incident_header}}
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
             Incident Description:
           </th>
           <td style=' border: 1px solid black ; padding: 5px '>
                   {{$incident_report->incident_brief}}
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
             photos:
           </th>
           <td style=' border: 1px solid black '>
                <img src="{{$incident_report->incident_image}}" alt="" srcset="">
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
             Potential outcome:
           </th>
           <td style=' border: 1px solid black '>
               {{$incident_report->potential_outcome}}      
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
             Causes:
           </th>
           <td style=' border: 1px solid black '>
                 Immediate Causes: 1.{{(isset($incident_reports_immediate_causes->primary))? $incident_reports_immediate_causes->primary :'N/A'}}
                                   2.{{(iset($incident_reports_immediate_causes->secondary))? $incident_reports_immediate_causes->secondary :'N/A'}}
                                   3.{{(isset($incident_reports_immediate_causes->tertiary))? $incident_reports_immediate_causes->tertiary :'N/A'}}
                                   <br>
                 Root causes:      1.{{$incident_reports_root_causes->primary}}
                                   2.{{$incident_reports_root_causes->secondary}}
                                   3.{{$incident_reports_root_causes->tertiary}}
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
                            Corrective/ Preventive Actions:
           </th>
           <td style=' border: 1px solid black '>
                  1.{{$incident_reports_preventive_actions->primary}}
                  2.{{$incident_reports_preventive_actions->secondary}}
                  3.{{$incident_reports_preventive_actions->tertiary}}
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black ; background-color: red; '>
             Key Message:
           </th>
           <td style=' border: 1px solid black '>
             {{$incident_report->Key_message}}
           </td>
       </tr>
      
       <tr>
           <th style=' border: 1px solid black ; background-color: red; '>
             Lessons learned:
           </th>
           <td style=' border: 1px solid black '>
           {{$incident_report->Lessons_learned}} 
           </td>
       </tr>
       <tr>
           <th style=' border: 1px solid black '>
                            Team 
                    engagement/ 
                    discussion 
                    topics
           </th>
           <td style=' border: 1px solid black '>
           {{$incident_report->team_engagement_and_discussion}}   
           </td>
       </tr>
</table>