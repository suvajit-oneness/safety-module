
<link rel="stylesheet" href="<?php echo public_path('admin_lte/bootstrap/css/bootstrap.min.css'); ?>">





{{-- Start --}}
@foreach ( $ir as $i  )
    
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: center">Incident Report</h1>
        </div>
    </div>
    <div class="row" style="border: 2px solid black;">
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <p><strong>Report Number: </strong>{{$i->report_no}}</p>
                </div>
                <div class="col-6 ml-auto" style="text-align: right;">
                    <p><strong>Report ID: </strong>{{$i->id}}</p>
                </div>
            </div>
            {{-- <hr style="border: 1px solid black;"> --}}
            {{-- step one --}}

            {{-- incident header --}}
            <h3 style="text-align: center;border-bottom:1px solid black;">{{$i->incident_header}}</h3>
            {{-- incident header end --}}
            <div class="row">
                <div class="col-12">
                    <p><strong>Incident Description: </strong>{{$i->incident_brief}}</p>  
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Vessel Name: </strong>{{$i->vessel_name}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Confidential: </strong>{{$i->confidential}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Created By: </strong>{{$i->created_by}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Media Involved: </strong>{{$i->media_involved}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Date of incident: </strong>{{$i->date_of_incident}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Time of incident: </strong>{{$i->time_of_incident_lt}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Date report created: </strong>{{$i->date_report_created}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>GMT: </strong>{{$i->time_of_incident_gmt}}</p>
                </div>
               
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Voy No: </strong>{{$i->voy_no}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Master: </strong>{{$i->master}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Chief officer: </strong>{{$i->chief_officer}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Chief Engineer: </strong>{{$i->chief_engineer }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Charterer: </strong>{{$i->charterer}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Agent: </strong>{{$i->agent}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Vessel Damage: </strong>{{$i->vessel_damage}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Cargo Damage: </strong>{{$i->cargo_damage}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Third Party Liability: </strong>{{$i->third_party_liability}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Environmental: </strong>{{$i->environmental}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Commercial/Service: </strong>{{$i->commercial}}</p>
                </div>
                {{-- <div class="col-6">
                    <p><strong>Environmental: </strong>{{$i->cargo_damage}}</p>
                </div> --}}
            </div>
            {{-- <hr style="border: 1px solid black;"> --}}
            {{-- step one end --}}
            <h3 style="text-align: center; border-bottom:1px solid black;">Crew Injury</h3>
            <div class="row">
                <div class="col-6">
                    <p><strong>Crew Injury: </strong>{{$i->crew_injury}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Other Personnel Injury: </strong>{{$i->other_personnel_injury}}</p>
                </div>
            </div>
            @if ($i->crew_injury == 'Yes')
            <div class="row">
                <div class="col-6">
                    <p><strong>Fatality: </strong>{{$i->fatality}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Lost Workday Case: </strong>{{$i->lost_workday_case}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Restricted Work Case: </strong>{{$i->restricted_work_case}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Medical Treatment Case: </strong>{{$i->medical_treatment_case}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Lost Time Injuries: </strong>{{$i->lost_time_injuries}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>First Aid Case: </strong>{{$i->first_aid_case}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Lead Investigator: </strong>{{$i->lead_investigator}}</p>
                </div>
                <div class="col-6 ml-auto">
                    <p><strong>Supporting Team Members: </strong></p>
                    <ul style="list-style: none;">
                        @foreach ($i as $member)
                            <li>{{$i->member_name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div>
           {{-- <div style=' border: 1px solid black ; background-color: red; '>
             Lessons learned:
           </div> --}}
           {{-- <div style=' border: 1px solid black '>
           {{$i->Lessons_learned}} 
           </div> --}}
       </div>
       {{-- <div>
           <div style=' border: 1px solid black '>
                            Team 
                    engagement/ 
                    discussion 
                    topics
           </div>
           <div style=' border: 1px solid black '>
           {{$i->team_engagement_and_discussion}}   
           </div>
       </div> --}}
       <div>
           <div style=' border: 1px solid black '>
                            Corrective/ Preventive Actions:
           </div>
           <div style=' border: 1px solid black '>
                  1.{{$i->pa_primary}}
                  2.{{$i->pa_secondary}}
                  3.{{$i->pa_tertiary}}
           </div>
       </div>
              {{-- <div>
                    <div style=' border: 1px solid black ; background-color: red; '>
                        Key Message:
                    </div>
                    <div style=' border: 1px solid black '>
                        {{$i->Key_message}}
                    </div>
             </div> --}}
              {{-- <div>
                    <div style=' border: 1px solid black '>
                        Potential outcome:
                    </div>
                    <div style=' border: 1px solid black '>
                        {{$i->Potential_outcome}}      
                    </div>
             </div> --}}
              <div>
                    <div style=' border: 1px solid black '>
                        Causes:
                    </div>
                    <div style=' border: 1px solid black '>
                            Immediate Causes: 1.{{$i->ic_primary}}
                                            2.{{$i->ic_secondary}}
                                            3.{{$i->ic_tertiary}}
                                            <br>
                            Root causes:      1.{{$i->rc_primary}}
                                            2.{{$i->rc_secondary}}
                                            3.{{$i->rc_tertiary}}
                    </div>
            </div>
            {{-- step two --}}
            {{-- step two end --}}
        </div>
    </div>
</div>
@endforeach

{{-- End --}}


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
