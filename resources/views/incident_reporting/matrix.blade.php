<div class="modal fade" style="" id="view_matrix" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl"  role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h2 class="modal-title font-weight-bold" id="exampleModalLongTitle">Incident Details</h2> <h5>Report Id : 3 </h5>
            </div> --}}
            <div class="modal-body text-left">
                {{-- <img src="{{asset('images/risk_investigation.svg')}}" alt="investigation-matrix" width="100%" height="auto"/> --}}
                <table border="1">
                    <tbody>
                       <tr>
                          <td colspan="7">INCIDENT CLASSIFICATION MATRIX</td>
                          {{-- <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td> --}}
                          <td colspan="2">Investigation Standards</td>
                          {{-- <td></td> --}}
                       </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;Safety</td>
                            <td>&nbsp;Health</td>
                            <td>&nbsp;Environment</td>
                            <td>&nbsp;Process Loss/Failure</td>
                            <td>Asset/Property Damage</td>
                            <td>&nbsp;Media Coverage / Public Attention</td>
                            <td>&nbsp;Investigation Level</td>
                            <td>Close-Out Authority</td>
                        </tr>


                        <tr>
                          <td style="padding:10px; color:white; background-color: #cc0202da">5 Extreme</td>
                          <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;-Multiple Fatalities</td>
                          <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;-Multiple health-related fatality</td>
                          <td style="padding:10px; color:white; background-color: #cc0202da">
                             <p>&nbsp;-Long-term impact<br /><br /></p>
                             <p>-Lasting impairment of ecosystem function</p>
                             <p>&nbsp;</p>
                             <p>-Widespace effect</p>
                             <p>&nbsp;</p>
                             <p>-severe impact to sensitive area</p>
                          </td>
                          <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;-Very serious operational failure resulting in ship being taken out of services for &gt; 30 days</td>
                          <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;- Very serious damage or loss to vessel / equioment . cargo with direct cost more than 2,000,000 USD</td>
                          <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;international Coverage</td>
                          <td style="padding:10px; color:black; background-color: #afaaaada" rowspan="2">&nbsp;Full Investigation by shore team or person(s) who are independent to the ship team</td>
                          <td style="padding:10px; color:black; background-color: #afaaaada" rowspan="2">&nbsp;GM</td>
                       </tr>

                       <tr>
                          <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;4 Major</td>
                          <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;- Single fatality , severe, permanent / partial disability</td>
                          <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;- Single health-related fatality</td>
                          <td style="padding:10px; color:white; background-color: #d87d05">
                             <p>&nbsp;-Medium to long-term impact</p>
                             <p>- Some impairment of ecosystem function</p>
                             <p>-Large area affected</p>
                          </td>
                          <td style="padding:10px; color:white; background-color: #d87d05">
                             <p>&nbsp;- Major operational failure resulting in ship being taken out of service between 15 and 30 days</p>
                             <p>-PSC detention</p>
                             <p>-ISM major non-conformity</p>
                          </td>
                          <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;- Major damage or loss to vessel / equipment / cargo with direct cost between 5000,000 and 2,000,000 USD</td>
                          <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;National Coverage</td>
                       </tr>

                       <tr>
                          <td style="padding:10px; color:black; background-color: orange">&nbsp;3 Medium</td>
                          <td style="padding:10px; color:black; background-color: orange">&nbsp;-Lost Time Injury (LTI), moderate permanent partial disability</td>
                          <td style="padding:10px; color:black; background-color: orange">&nbsp;-Health Repatriation Case (HRC)</td>
                          <td style="padding:10px; color:black; background-color: orange">
                             <p>&nbsp;- Short to medium-term impact </p>
                             <p>-Local area affected</p>
                             <p>-Not affecting ecosystem function</p>
                          </td>
                          <td style="padding:10px; color:black; background-color: orange">
                             <p>&nbsp;-Moderate operational failure resulting in ship being taken out of service between 1 and 15 days</p>
                             <p>-Flag State Detention</p>
                          </td>
                          <td style="padding:10px; color:black; background-color: orange">&nbsp;-Moderate damage or loss to Vessel/equipment / cargo with direct cost between 200,000&nbsp; and 500,000 USD&nbsp; </td>
                          <td style="padding:10px; color:black; background-color: orange">&nbsp;Regional Coverage</td>
                          <td rowspan="3" style="padding:10px; color:black; background-color: #afaaaada">&nbsp;Detailed investigation by relevant&nbsp; ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.</td>
                          <td rowspan="2" style="padding:10px; color:black; background-color: #afaaaada">&nbsp;D/GM</td>
                       </tr>

                       <tr>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;2 Minor</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;-RWC (Restricted Work Case)</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;-Health Medical Treatment Case(HMTC)</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">
                             <p>&nbsp;-Tempo impact</p>
                             <p>-Minor effects to small&nbsp; area</p>
                          </td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;- Minor operational failure resulting in ship being taken out of services for &lt; 1 day</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;-Minor operational failure resulting in ship being taken out of service for &lt; 1-Minor damage or loss to vessel/equipment/cargo with direct cost between 10,000 to 200,000 USD</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;Local Coverage</td>
                       </tr>
                       <tr>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;1 Slight</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;- FAC (First Aid Case, MTC(Medical Treatment Case)</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;- Health Treatment Onboard Case (HTOC)/ Potential Occupational Health Incident (POHI)</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">
                             <p>&nbsp;- Low impact with no lasting effect </p>
                             <p>&nbsp;</p>
                             <p>-Minimal area exposed</p>
                          </td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;-Notable incident with no impact on operations</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;- Insignificant damage or loss to&nbsp; vessel / equipment / cargo with direct cost less than 10,000 USD</td>
                          <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;No Coverage</td>
                          <td style="padding:10px; color:black; background-color: #afaaaada">&nbsp;S/M or F/M as applicable</td>
                       </tr>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle mr-1"></i>Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view_matrix" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Incident Classification Matrix</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
                   <table id="maxtrix_dynamic_table" style=" width:100% ; border:1px solid black ;  ">
                           <tr>
                               <th style= " width:100% ; border:1px solid black " ></th>
                               <th id="dynamic_header" style=" width:100% ; border:1px solid black "></th>
                               <th style=" width:100% ; border:1px solid black ; background-color:#afaaaada ">Investigation Level</th>
                               <th style=" width:100% ; border:1px solid black ; background-color:#afaaaada ">Close-Out Authority</th>
                           </tr>
                           <tr>
                               <th id="dynamic_column" style=" width:100% ; border:1px solid black "></th>
                               <th id="dynamic_data" style=" width:100% ; border:1px solid black "></th>
                               <th id="dynamic_il" style=" width:100% ; border:1px solid black ;  background-color:#afaaaada"></th>
                               <th id="dynamic_co" style=" width:100% ; border:1px solid black ; background-color:#afaaaada"></th>
                           </tr>
                   </table>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
       </div>
     </div>
   </div>
 </div>