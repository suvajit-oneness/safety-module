
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

<style>
    hr {
        margin-top:5px;
 margin-bottom:5px;
 height:5px;
 width:100%;
 border-top:1px solid black;
}
</style>


{{-- Start --}}
<div class="p-5 text-dark">
        <h1 class="text-center">Near Miss Report</h1>

        <br>
        @foreach ($nmr_arr as $nmr )
            
        {{-- Date --}}
        <div class="my-5">
            <span style="font-weight:bolder;">Report ID :</span> {{$nmr->id}}
        </div>


        {{-- Date --}}
        <div class="my-5">
            <span style="font-weight:bolder;">Date :</span> {{$nmr->date}}
        </div>

        {{-- Describtion --}}
        <div class="my-5">
            <span class="font-weight-bold">Description : </span> <br>
            <p>{{ $nmr->describtion }}</p>
        </div>


        {{-- Incident Type --}}
        <div class="my-5">
            <span class="font-weight-bold">Incident Type :</span>
            <table class="table">
                <tbody>
                <tr>
                    <td>{{ $nmr->incident_type_one }}</td>

                    @if ($nmr->incident_type_two != '-----')
                        <td>{{ $nmr->incident_type_two }}</td>
                    @endif
                    @if ( $nmr->incident_type_three != '-----')
                        <td>{{ $nmr->incident_type_three }}</td>
                    @endif
                </tr>

                </tbody>
            </table>
        </div>


        {{-- Corrective Action --}}
        <div class="my-5">
            <span class="font-weight-bold">Corrective Action</span> <br>
            {{ $nmr->corrective_action }}
        </div>


        {{-- Immediate Causes --}}
        <div class="my-5">
            <span class="font-weight-bold">Immediate Causes :</span>
            <table class="table">
                <tbody>
                <tr>
                    <td>{{ $nmr->immediate_cause_one }}</td>

                    @if ($nmr->immediate_cause_two != '-----')
                        <td>{{ $nmr->immediate_cause_two }}</td>
                    @endif
                    @if ($nmr->immediate_cause_three != '-----')
                        <td>{{ $nmr->immediate_cause_three }}</td>
                    @endif
                </tr>

                </tbody>
            </table>
        </div>


        {{-- Root Causes --}}
        <div class="my-5">
            <span class="font-weight-bold">Root Causes :</span>
            <table class="table m-0">
                <tbody>
                <tr>
                    <td>
                        <ul>
                            @php
                               $nmr->root_causes_one = explode(",",$nmr->root_causes_one);
                            @endphp
                            @foreach ( $nmr->root_causes_one as $v )
                                <li>{{ $v }}</li>
                            @endforeach
                        </ul>
                    </td>

                    @if ( $nmr->root_causes_two != '-----' )
                        <td>
                            <ul>
                                @php
                                    $nmr->root_causes_two = explode(",",$nmr->root_causes_two);
                                @endphp
                                @foreach ( $nmr->root_causes_two as $v )
                                    <li>{{ $v }}</li>
                                @endforeach
                            </ul>
                        </td>
                    @endif
                    @if (  $nmr->root_causes_three != '-----' )
                    <td>
                        <ul>
                            @php
                                $nmr->root_causes_three = explode(",",$nmr->root_causes_three);
                            @endphp
                            @foreach ( $nmr->root_causes_three as $v )
                                <li>{{ $v }}</li>
                            @endforeach
                        </ul>
                    </td>
                    @endif
                </tr>

                </tbody>
            </table>
        </div>





        {{-- Preventive Action --}}
        <div class="my-5">
            <span class="font-weight-bold">Preventive Action :</span>
            <table class="table">
                <tbody>
                <tr>
                    <td>
                        <ul>
                            @php
                                $nmr->preventive_actions_one = explode(",",$nmr->preventive_actions_one);
                            @endphp
                            @foreach ( $nmr->preventive_actions_one as $v )
                                <li>{{ $v }}</li>
                            @endforeach
                        </ul>
                    </td>

                    @if ($nmr->preventive_actions_two != '-----')
                        <td>
                            <ul>
                                @php
                                    $nmr->preventive_actions_two = explode(",",$nmr->preventive_actions_two);
                                @endphp
                                @foreach ( $nmr->preventive_actions_two as $v )
                                    <li>{{ $v }}</li>
                                @endforeach
                            </ul>
                        </td>
                    @endif
                    @if ($nmr->preventive_actions_three != '-----')
                        <td>
                            <ul>
                                @php
                                    $nmr->preventive_actions_three = explode(",",$nmr->preventive_actions_three);
                                @endphp
                                @foreach ( $nmr->preventive_actions_three as $v )
                                    <li>{{ $v }}</li>
                                @endforeach
                            </ul>
                        </td>
                    @endif
                </tr>

                </tbody>
            </table>
        </div>


            {{-- Closed --}}
            <div class="my-5">
                <span class="font-weight-bold">Closed : </span> {{ $nmr->close }}
            </div>


            {{-- Office Coment --}}
            <div class="my-5">
                <span class="font-weight-bold">Office Comments : </span> {{ $nmr->close }}
            </div>


            {{-- Lesson Learnt --}}
            <div class="my-5">
                <span class="font-weight-bold">Lesson Learnt : </span> {{ $nmr->close }}
            </div>

            <hr>
        @endforeach






</div>
{{-- End --}}


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
