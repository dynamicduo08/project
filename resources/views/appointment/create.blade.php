@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/appointment.JPG') }}" alt="Patient Management">Appointment Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Create Appointment</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Create Appointment
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('save-appointment') }}" aria-label="{{ __('Create Appointment') }}">
                    @csrf
                    {{-- {{ dd($data['doctors']) }} --}}
                    @if(Auth::user()->type != 3)
                    <div class="form-group row">
                        <label for="patient" class="col-md-4 col-form-label text-md-right">{{ __('Select Patient:') }}</label>
        
                        <div class="col-md-6">
                            <select name="patient_id" id="patient" class="form-control{{ $errors->has('patient') ? ' is-invalid' : '' }}" required>
                                <option value="" selected disabled>-- Select patient --</option>
                                @foreach($data['patients'] as $patient)
                                    <option {{ old("patient_id") == $patient['id'] ? "selected" : "" }} value="{{ $patient['id'] }}">{{ $patient['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                        <input type="hidden"  name="patient_id" value="{{ Auth::user()->id }}">
                    @endif
                    @if(Auth::user()->type != 2)
                        <div class="form-group row">
                            <label for="doctor" class="col-md-4 col-form-label text-md-right">{{ __('Select Doctor:') }}</label>
            
                            <div class="col-md-6">
                                <select name="doctor_id" id="doctor" class="form-control{{ $errors->has('doctor') ? ' is-invalid' : '' }}" required>
                                    <option value="" selected disabled>-- Select Doctor --</option>
                                    @foreach($data['doctors'] as $doctor)
                                        <option  {{ old("doctor_id") == $doctor['id'] ? "selected" : "" }} value="{{ $doctor['id'] }}">{{ $doctor['doctorDetails']['specialization'] }} - {{ $doctor['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden"  name="doctor_id" value="{{ Auth::user()->id }}">
                    @endif
        
                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Select Date') }}</label>
        
                        <div class="col-md-6">
                          <input id="date" onchange='no_weekends(this.value);getminutes();' min='{{date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))))}}' onkeydown="return false;"  name="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" type="date" >
                        </div>
                        <br>
                    </div>
                    <div class="form-group row">
                        <label  class="col-md-4 col-form-label text-md-right">{{ __('Available Slots') }} </label>
                        <label  class="col-md-2  col-form-label text-info">AM : <span id='available_am'>0</span> :  PM : <span id='available_pm'>0</span> </label>
                    
                    </div>
                    <div class="form-group row">
                        <label for="real_time" class="col-md-4 col-form-label text-md-right">{{ __('Select Time:') }}</label>
        
                        <div class="col-md-6">
                            <select name="real_time" id="real_time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" required>
                                <option value="" selected disabled>-- Select Time --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('Select Period:') }}</label>
                        <div class="col-md-6">
                            <select name="time" id="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" required>
                                <option value="" selected disabled>-- Select Period --</option>
                                <!-- <option  value="AM">Morning</option>
                                <option value="PM">Afternoon</option> -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-calendar"></i> Set Appointment</button>
                    </div>
        
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    function no_weekends(value)
    {   
        // alert(value);

        var day = new Date(value).getUTCDay();

        if((day == 0) || (day == 6))
        {
            document.getElementById('date').value = "";
            alert('Weekends not allowed');
        }
        else
        {
            // alert(value);
            $.ajax({    
            
                type: "GET",
                url: "{{ url('check_schedule') }}",            
                data: {
                    "date" : value,
                }     ,
                dataType: "json",   
                success: function(data){    
                    document.getElementById("available_am").innerHTML = data[0].am;
                    document.getElementById("available_pm").innerHTML = data[0].pm;
                    var times = getminutes();
                    // console.log(times);
                    $(".time-data").remove();
                     if(data[0].am != 0)
                    {
                    $("#time").append("<option class='time-data' value='AM'>AM</option>");
                    }
                    if(data[0].pm != 0)
                    {
                    $("#time").append("<option class='time-data' value='PM'>PM</option>");
                    }
                    for(i = 0;i < times.length;i++)
                    {
                        console.log(times[i]);
                        $("#real_time").append("<option class='time-data' value='"+times[i]+"'>"+times[i]+"</option>");
                    }
                   
                },
                error: function(e)
                {
                    console.log(e);
                }
            });
        }
        
    }
    function getminutes()
    {
        var x = 15; //minutes interval
        var times = []; // time array
        var tt = 540; // start time
        var ap = ['AM', 'PM']; // AM-PM

        //loop to increment the time and push results in array
        for (var i=0;tt<17*60; i++) {
        var hh = Math.floor(tt/60); // getting hours of day in 0-24 format
        var mm = (tt%60); // getting minutes of the hour in 0-55 format
        if(hh == 12)
        {
        times[i] = ("0" + (hh % 12)).slice(-2) + ':' + ("0" + mm).slice(-2) + " "+ ap[Math.floor(hh/12)]; // pushing data in array in [00:00 - 12:00 AM/PM format]
        }
        else
        {
        times[i] = ("0" + (hh % 12)).slice(-2) + ':' + ("0" + mm).slice(-2) + " "+ ap[Math.floor(hh/12)]; // pushing data in array in [00:00 - 12:00 AM/PM format]    
        }
        tt = tt + x;
        }
        return times;
    }
</script>
@include('layouts.dashboard.footer')
@endsection
