
{{--  style  --}}
<style>
    table, th, td {
        border: 1px solid black;
    }
    table{
        padding: 20px;
    }
    th, td{
        padding: 10px;
    }
</style>


{{-- Start --}}

<div class="container">


    {{-- Start --}}
    <div class="container" style="border: 2px solid black;">

        {{--  logo and title  --}}
        <table style="width:100%;">
            <tr>
                <td style="width:10rem; text-align: center;">
                    <img src='http://localhost:8000/images/TCCflagwithoutbackground.png' height="100px" width='100px'  >
                </td>
                <td style="text-align: center;">
                    Incident Report
                        <br>
                    {{$incident_report->incident_header}}
                </td>
            </tr>
        </table>

        {{--  Report Data  --}}
        <table style="width:100%;">
            {{-- ============================ STEP ONE ======================= --}}
                <tr>
                    <td colspan="2" style="width:50%; text-align: center;">Report ID : {{$ID}} </td>
                </tr>

                {{-- VESSEL NAME AND CONFIDENTIAL --}}
                <tr>
                    <td><strong>Vessel Name: </strong>{{$incident_report->vessel_name}} </td>
                    <td><strong>Confidential: </strong>{{$incident_report->confidential}}</td>
                </tr>

                {{-- Created By(Rank) && Created By(Name): && Media Involved: --}}
                <tr>
                    <th><strong><strong>Media Involved: </strong>{{$incident_report->media_involved}} </strong></th>
                    <th></th>
                </tr>


            {{-- ============================ STEP ONE ENDS. ======================= --}}
        </table>
        {{--  Report Data /end.  --}}
    </div>
    {{-- End --}}















    {{-- Report Title
    ======================== --}}
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: center">Incident Report</h1>
        </div>
    </div>
    {{-- Report Title ENDS.
    ======================== --}}

    {{-- Report Data
    =========================== --}}
    <div class="row" style="border: 2px solid black;">
        <div class="col-12">
            <div class="row">

                <div class="col-12 ml-auto my-5" style="text-align: right;">
                    <p><strong>Report ID: </strong>{{$ID}}</p>
                </div>
            </div>



            {{-- ============================ STEP ONE ======================= --}}

                {{-- HEADING  --}}
                <h3 style="text-align: center;border-bottom:1px solid black;">{{$incident_report->incident_header}}</h3>

                {{-- VESSEL NAME AND CONFIDENTIAL --}}
                <div class="row">
                    {{-- vESSEL NAME --}}
                    <div class="col-6">
                        <p><strong>Vessel Name: </strong>{{$incident_report->vessel_name}}</p>
                    </div>
                    {{-- CONFIDENTIAL --}}
                    <div class="col-6 ml-auto">
                        <p><strong>Confidential: </strong>{{$incident_report->confidential}}</p>
                    </div>
                </div>

                {{-- Created By(Rank) && Created By(Name): && Media Involved: --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Created By(Rank): </strong>{{$incident_report->created_by_name}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>Created By(Name): </strong>{{$incident_report->created_by_rank}}</p>
                    </div>
                </div>

                {{-- Media Involved --}}
                <div class="row">
                    <div class="col-12 ml-auto"> <p><strong>Media Involved: </strong>{{$incident_report->media_involved}}</p></div>
                </div>

                {{-- Date of incident && Time of incident --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Date of incident: </strong>{{$incident_report->date_of_incident}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>Time of incident: </strong>{{$incident_report->time_of_incident_lt}}</p>
                    </div>
                </div>

                {{-- Date report created &&  GMT --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Date report created: </strong>{{$incident_report->date_report_created}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>GMT: </strong>{{$incident_report->time_of_incident_gmt}}</p>
                    </div>

                </div>

                {{-- Voy No && Master --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Voy No: </strong>{{$incident_report->voy_no}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>Master: </strong>{{$incident_report->master}}</p>
                    </div>
                </div>

                {{-- Chief officer && Chief Engineer  --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Chief officer: </strong>{{$incident_report->chief_officer}}</p>
                    </div>
                    <div class="col-6 ml-auto ">
                        <p><strong>Chief Engineer: </strong>{{$incident_report->chief_engineer}}</p>
                    </div>
                </div>

                {{--  1st Eng  --}}
                <div class="row">
                    <div class="col-4">
                        <p><strong> 1st Eng : </strong>{{$incident_report->first_engineer}}</p>
                    </div>
                </div>

                {{-- Charterer && Agent --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Charterer: </strong>{{$incident_report->charterer}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>Agent: </strong>{{$incident_report->agent}}</p>
                    </div>
                </div>

                {{-- Vessel Damage && Cargo Damage &&  --}}
                <div class="row">
                    <div class="col-4">
                        <p><strong>Vessel Damage: </strong>{{$incident_report->vessel_damage}}</p>
                    </div>
                    <div class="col-4 ml-auto">
                        <p><strong>Cargo Damage: </strong>{{$incident_report->cargo_damage}}</p>
                    </div>
                </div>

                {{--  Third Party Liability  --}}
                <div class="row">
                    <div class="col-4">
                        <p><strong>Third Party Liability: </strong>{{$incident_report->third_party_liability}}</p>
                    </div>
                </div>

                {{-- Environmental && Commercial/Service --}}
                <div class="row">
                    <div class="col-6 ">
                        <p><strong>Environmental: </strong>{{$incident_report->environmental}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>Commercial/Service: </strong>{{$incident_report->commercial}}</p>
                    </div>
                </div>


            {{-- ============================ STEP ONE ENDS. ======================= --}}


            {{-- ============================ STEP TWO ======================= --}}

                {{-- HEADING --}}
                <h3 style="text-align: center; border-bottom:1px solid black;">Crew Injury</h3>

                {{-- Crew Injury && Other Personnel Injury --}}
                <div class="row">
                    <div class="col-6">
                        <p><strong>Crew Injury: </strong>{{$incident_report->crew_injury}}</p>
                    </div>
                    <div class="col-6 ml-auto">
                        <p><strong>Other Personnel Injury: </strong>{{$incident_report->other_personnel_injury}}</p>
                    </div>
                </div>

                {{-- IF CREW INJURED  --}}
                @if ($incident_report->crew_injury == 'Yes')

                    {{-- Fatality && Lost Workday Case --}}
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Fatality: </strong>{{$incident_reports_crew_injury->fatality}}</p>
                        </div>
                        <div class="col-6 ml-auto">
                            <p><strong>Lost Workday Case: </strong>{{$incident_reports_crew_injury->lost_workday_case}}</p>
                        </div>
                    </div>
                    {{-- Restricted Work Case && Medical Treatment Case --}}
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Restricted Work Case: </strong>{{$incident_reports_crew_injury->restricted_work_case}}</p>
                        </div>
                        <div class="col-6 ml-auto">
                            <p><strong>Medical Treatment Case: </strong>{{$incident_reports_crew_injury->medical_treatment_case}}</p>
                        </div>
                    </div>
                    {{-- Lost Time Injuries && First Aid Case --}}
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Lost Time Injuries: </strong>{{$incident_reports_crew_injury->lost_time_injuries}}</p>
                        </div>
                        <div class="col-6 ml-auto">
                            <p><strong>First Aid Case: </strong>{{$incident_reports_crew_injury->first_aid_case}}</p>
                        </div>
                    </div>
                    {{-- Lead Investigator && Supporting Team Members --}}
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Lead Investigator: </strong>{{$incident_report->lead_investigator}}</p>
                        </div>
                        <div class="col-6 ml-auto">
                            <p><strong>Supporting Team Members: </strong></p>
                            <ul style="list-style: none;">
                                @foreach ($incident_reports_supporting_team_members as $member)
                                    <li>{{$member->member_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            {{-- ============================ STEP TWO ENDS. ======================= --}}


            {{-- ============================ STEP THREE ======================= --}}
                    {{-- HEADING --}}
                    <h3 style="text-align: center; border-bottom:1px solid black;">EVENT INFORMATION</h3>

                   {{--  Place of the incident  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                    Place of the incident :
                                    {{$incident_reports_event_information->place_of_incident}}
                               </strong>
                           </p>
                       </div>
                   </div>

                   @if ( $incident_reports_event_information->place_of_incident == 'Port')
                       <div class="row">
                           <div class="col-12"><p><strong> {{ $incident_reports_event_information->place_of_incident_position }} </strong></p></div>
                       </div>
                   @endif
                   @if ( $incident_reports_event_information->place_of_incident == 'At Sea')
                        {{--  Longitude  --}}
                       <div class="row">
                           <div class="col-12"><p><strong> Latitude : {{ $incident_reports_event_information->lat_1 }} {{ $incident_reports_event_information->lat_2 }} {{ $incident_reports_event_information->lat_3 }} </strong></p></div>
                       </div>
                       {{--  Latitude  --}}
                       <div class="row">
                           <div class="col-12"><p><strong> Longitude : {{ $incident_reports_event_information->long_1 }} {{ $incident_reports_event_information->long_2 }} {{ $incident_reports_event_information->long_3 }} </strong></p></div>
                       </div>
                   @endif

                   {{--  Date of incident  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                    Date of incident :
                                    {{ $incident_reports_event_information->date_of_incident }}
                               </strong>
                           </p>
                       </div>
                   </div>
                   {{--  Time of incident  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                    Time of incident :
                                    {{ $incident_reports_event_information->time_of_incident_lt }}
                               </strong>
                           </p>
                       </div>
                   </div>
                   {{--  GMT  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                    GMT :
                                    {{ $incident_reports_event_information->time_of_incident_gmt }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Location of incident  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Location of incident :
                                   {{ $incident_reports_event_information->location_of_incident  }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Operation --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Operation:
                                   {{ $incident_reports_event_information->operation  }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Vessel Condition --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Vessel Condition:
                                   {{ $incident_reports_event_information->vessel_condition  }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Cargo type and quantity --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Cargo type and quantity:
                                   {{ $incident_reports_event_information->cargo_type_and_quantity  }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Wind force  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Wind force :
                                   {{$incident_reports_weather->wind_force }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Direction (Degree)  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Direction (Degree) :
                                   {{$incident_reports_weather->wind_direction }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Swell  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Swell :
                                   {{$incident_reports_weather->swell_height }} <br>
                                   {{$incident_reports_weather->swell_length }} <br>
                                   {{$incident_reports_weather->swell_direction }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Sky  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Sky :
                                   {{$incident_reports_weather->sky }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Visibility  --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Visibility :
                                   {{$incident_reports_weather->visibility }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Rolling   --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Rolling   :
                                   {{$incident_reports_weather->rolling }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  pitching   --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Pitching   :
                                   {{$incident_reports_weather->pitching }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Illumination   --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Illumination   :
                                   {{$incident_reports_weather->illumination }}
                               </strong>
                           </p>
                       </div>
                   </div>


                   {{--  P&I Club informed   --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   P&I Club informed   :
                                   {{$incident_report->p_n_i_club_informed }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  H&M Informed   --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   H&M Informed   :
                                   {{$incident_report->h_n_m_informed }}
                               </strong>
                           </p>
                       </div>
                   </div>

                   {{--  Remarks   --}}
                   <div class="row">
                       <div class="col-12">
                           <p>
                               <strong>
                                   Remarks   :
                                   {{$incident_report->type_of_loss_remarks }}
                               </strong>
                           </p>
                       </div>
                   </div>





            {{-- ============================ STEP THREE ENDS. ======================= --}}


            {{-- ============================ STEP FOUR ======================= --}}
                    {{-- HEADING --}}
                    <h3 style="text-align: center; border-bottom:1px solid black;">INCIDENT IN BRIEF</h3>

                    {{--  Incident Brief  --}}
                    <div class="row">
                        <div class="col-12">
                            <p>
                                <strong>
                                    Incident Brief :
                                    {{$incident_report->incident_brief}}
                                </strong>
                            </p>
                        </div>
                    </div>


                    {{--  incident_reports_event_logs  --}}
                    @foreach ( $incident_reports_event_logs as $event_log )
                        <hr>
                        {{--  Date  --}}
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <strong>
                                        Date :
                                        {{$event_log->date}}
                                    </strong>
                                </p>
                            </div>
                        </div>

                        {{--  Time  --}}
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <strong>
                                        Time :
                                        {{$event_log->time}}
                                    </strong>
                                </p>
                            </div>
                        </div>

                        {{--  Remarks  --}}
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <strong>
                                        Remarks :
                                         {{$event_log->remarks}}
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <hr>
                    @endforeach
            {{-- ============================ STEP FOUR ENDS. ======================= --}}


            {{-- ============================ STEP FIVE ======================= --}}
                    {{-- HEADING --}}
                    <h3 style="text-align: center; border-bottom:1px solid black;">Incident Pics</h3>

                    {{--  Drawing Image  --}}
                    <div class="row">
                        <div class="col-12">
                            @if($incident_image != 'N/A')
                                <img height="200" width="200" src="{{$incident_image}}" alt="" sizes="" srcset="">
                            @else
                                <h6>{{$incident_image}}</h6>
                            @endif

                        </div>
                    </div>
            {{-- ============================ STEP FIVE ENDS. ======================= --}}


            {{-- ============================ STEP SIX ======================= --}}
                    {{-- HEADING --}}
                    <h3 style="text-align: center; border-bottom:1px solid black;">INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS</h3>

                    {{--  Event Details  --}}
                    @foreach ( $incident_reports_event_details as $event_details )
                        <div class="row">
                            <div class="col-12"><p><strong>Event Detail : {{$event_details->details}}</strong></p></div>
                        </div>
                    @endforeach

                    <hr>
                    {{--  Risk Category  --}}
                    <div class="row">
                        <div class="col-12"> <p><strong> Risk Category : {{$incident_report->risk_category}} </strong></p></div>
                    </div>

                    {{--  SAFETY  --}}
                    @if($incident_report->risk_category == 'SAFETY')
                        <div class="row"><div class="col-12"><p><strong> {{$incident_reports_risk_details->risk}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Severity :  {{$incident_reports_risk_details->severity}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Likelihood :  {{$incident_reports_risk_details->likelihood}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Result : {{$incident_reports_risk_details->result}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Name of the person : {{$incident_reports_risk_details->name_of_person}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Type of injury : {{$incident_reports_risk_details->type_of_injury}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Associated cost : {{$incident_reports_risk_details->associated_cost_usd}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Select Currency : {{$incident_reports_risk_details->currency_code}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Local Amount : {{$incident_reports_risk_details->associated_cost_loca}} </strong></p></div></div>
                    @endif

                    {{--  HEALTH  --}}
                    @if($incident_report->risk_category == 'HEALTH')
                        <div class="row"><div class="col-12"><p><strong> {{$incident_reports_risk_details->risk}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Severity :  {{$incident_reports_risk_details->severity}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Likelihood :  {{$incident_reports_risk_details->likelihood}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong>  Result : {{$incident_reports_risk_details->result}}  </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Name of the person : {{$incident_reports_risk_details->name_of_person}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Type of injury : {{$incident_reports_risk_details->type_of_injury}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Associated cost : {{$incident_reports_risk_details->associated_cost_usd}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Select Currency : {{$incident_reports_risk_details->currency_code}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong>  Local Amount : {{$incident_reports_risk_details->associated_cost_loca}} </strong></p></div></div>
                    @endif

                    {{--  ENVIRONMENT  --}}
                    @if($incident_report->risk_category == 'ENVIRONMENT')
                        <div class="row"><div class="col-12"><p><strong> {{$incident_reports_risk_details->risk}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Severity :  {{$incident_reports_risk_details->severity}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Likelihood :  {{$incident_reports_risk_details->likelihood}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Result : {{$incident_reports_risk_details->result}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Type of pollution : {{$incident_reports_risk_details->type_of_pollution}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Quantity of pollutant : {{$incident_reports_risk_details->quantity_of_pollutant}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Associated cost : {{$incident_reports_risk_details->associated_cost_usd }} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Select Currency : {{$incident_reports_risk_details->currency_code}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Contained spill : {{$incident_reports_risk_details->contained_spill}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Total Spilled quantity : {{$incident_reports_risk_details->total_spilled_quantity}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Spilled in Water : {{$incident_reports_risk_details->spilled_in_water}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Spilled Ashore : {{$incident_reports_risk_details->spilled_ashore}} </strong></p></div></div>
                    @endif

                    {{--  OPERATIONAL IMPACT  --}}
                    @if($incident_report->risk_category == 'OPERATIONAL IMPACT')
                        <div class="row"><div class="col-12"><p><strong> Vessel : {{$incident_reports_risk_details->vessel}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Cargo : {{$incident_reports_risk_details->cargo}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Third Party : {{$incident_reports_risk_details->third_party }} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> {{$incident_reports_risk_details->risk}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Severity :  {{$incident_reports_risk_details->severity}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Likelihood :  {{$incident_reports_risk_details->likelihood}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong>  Result : {{$incident_reports_risk_details->result}}  </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong>  Damage description : {{$incident_reports_risk_details->damage_description}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Off hire if any : {{$incident_reports_risk_details->off_hire }} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Associated cost : {{$incident_reports_risk_details->associated_cost_usd }} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Select Currency : {{$incident_reports_risk_details->currency_code}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Local Amount : {{$incident_reports_risk_details->associated_cost_loca}} </strong></p></div></div>
                    @endif

                    {{--  MEDIA  --}}
                    @if($incident_report->risk_category == 'MEDIA')
                        <div class="row"><div class="col-12"><p><strong> {{$incident_reports_risk_details->risk}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Severity :  {{$incident_reports_risk_details->severity}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Likelihood :  {{$incident_reports_risk_details->likelihood}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong>  Result : {{$incident_reports_risk_details->result}}  </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Description : {{$incident_reports_risk_details->description}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Associated cost : {{$incident_reports_risk_details->associated_cost_usd}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Select Currency : {{$incident_reports_risk_details->currency_code}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Local Amount : {{$incident_reports_risk_details->associated_cost_loca}} </strong></p></div></div>
                        <div class="row"><div class="col-12"><p><strong> Type : {{$incident_reports_risk_details->type}} </strong></p></div></div>
                    @endif
                    <hr>




                    {{--  Immediate Causes dropdown  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Immediate Causes: </strong>{{(isset($incident_reports_immediate_causes->primary))? $incident_reports_immediate_causes->primary:'N/A'}}</p> <br>
                             <p><strong>Immediate Causes: </strong>{{(isset($incident_reports_immediate_causes->secondary))?$incident_reports_immediate_causes->secondary: 'N/A'}} </p> <br>
                             <p><strong>Immediate Causes: </strong>{{(isset($incident_reports_immediate_causes->tertiary))?$incident_reports_immediate_causes->tertiary : 'N/A'}}</p>
                        </div>
                    </div>
            {{-- ============================ STEP SIX ENDS. ======================= --}}


            {{-- ============================ STEP SEVEN ======================= --}}
                    {{-- HEADING --}}
                    <h3 style="text-align: center; border-bottom:1px solid black;">5 Whys</h3>

                    {{--  Incident  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Incident: </strong>{{$incident_reports_five_why->incident}}</p>
                        </div>
                    </div>

                    {{--  First why  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>First why: </strong>{{$incident_reports_five_why->first_why}}</p>
                        </div>
                    </div>
                    {{--  Second why  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Second why: </strong>{{$incident_reports_five_why->second_why}}</p>
                        </div>
                    </div>
                    {{--  Third why  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Third why: </strong>{{$incident_reports_five_why->third_why}}</p>
                        </div>
                    </div>
                    {{--  Fourth why  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Fourth why: </strong>{{$incident_reports_five_why->fourth_why}}</p>
                        </div>
                    </div>
                    {{--  Fifth why  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Fifth why: </strong>{{$incident_reports_five_why->fifth_why}}</p>
                        </div>
                    </div>
                    {{--  Root causes text-field  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Root Causes : </strong>{{$incident_reports_five_why->root_cause}}</p>
                        </div>
                    </div>


                    {{--  Root causes dropdown  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong>Root Causes: </strong>{{(isset($incident_reports_root_causes->primary))? $incident_reports_root_causes->primary : 'N/A'}}</p> <br>
                             <p><strong>Root Causes: </strong>{{(isset($incident_reports_root_causes->secondary))? $incident_reports_root_causes->secondary : 'N/A'}}</p> <br>
                             <p><strong>Root Causes: </strong>{{(isset($incident_reports_root_causes->tertiary))? $incident_reports_root_causes->tertiary : 'N/A'}}</p>
                        </div>
                    </div>

                    {{--  Preventive Action dropdown  --}}
                    <div class="row">
                        <div class="col-12">
                             <p><strong> Preventive Actions : </strong>{{(isset($incident_reports_preventive_actions->primary))? $incident_reports_preventive_actions->primary : 'N/A'}}</p> <br>
                             <p><strong> Preventive Actions : </strong>{{(isset($incident_reports_preventive_actions->secondary))? $incident_reports_preventive_actions->secondary : 'N/A'}}</p> <br>
                             <p><strong> Preventive Actions : </strong>{{(isset($incident_reports_preventive_actions->tertiary))? $incident_reports_preventive_actions->tertiary : 'N/A'}}</p>
                        </div>
                    </div>



                    {{--  Comments  --}}
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Comments : {{$incident_report->comments_five_why_section}}</strong></p>
                        </div>
                    </div>


                    {{--  Follo-up actions  --}}
                    @foreach ($incident_reports_follow_up_actions as $follow_up_action )
                    <hr>
                        <div class="row">
                            <div class="col-12"> <p><strong>Action No . : {{$follow_up_action->sl_no}} </strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Description : {{$follow_up_action->description}}</strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>PIC : {{$follow_up_action->pic}}</strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Department :  {{$follow_up_action->department}}</strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Target Date : {{$follow_up_action->target_date }}</strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Completed Date :  {{$follow_up_action->completed_date}}</strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Evidence Uploaded :  {{$follow_up_action->evidence_uploaded}}</strong></p></div> <br>

                            @foreach ( $followUp_image_array as $key => $value )
                                @if($follow_up_action->id  == $key)
                                    <img height="200" width="200" src="{{$value}}" alt="" sizes="" srcset="">
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Cost :  {{$follow_up_action->cost}}</strong></p></div> <br>
                        </div>
                        <div class="row">
                            <div class="col-12"> <p><strong>Comments :  {{$follow_up_action->comments}}</strong></p></div>
                        </div>
                    @endforeach

                    {{--  Risk Assesment Evaluated  --}}
                    <div class="row">
                        <div class="col-12">
                            <p>
                                <strong>Risk Evaluatd : {{$incident_report->is_evalutated}}</strong>
                            </p>
                        </div>
                    </div>

                    {{--  Risk Assesment Evaluated File  --}}
                    <div class="row">
                        <div class="col-12">
                            @if($risk_assesment_evaluated_file_upload != 'N/A')
                                <img height="200" width="200" src="{{$risk_assesment_evaluated_file_upload}}" alt="" sizes="" srcset="">
                            @else
                                <h6>{{$risk_assesment_evaluated_file_upload}}</h6>
                            @endif

                        </div>
                    </div>
            {{-- ============================ STEP SEVEN ENDS. ======================= --}}





        </div>
    </div>
    {{-- Report Data ENDS.
    =========================== --}}
</div>

{{-- End --}}



