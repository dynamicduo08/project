@extends('layouts.dashboard.main')

@section('content')
<main>
    <div class="container-fluid" id="app">
        <h1 class="mt-4"><img class="card-img-top img-thumbnail" style="height: 60px; width : 60px" src="{{ asset('assets/quick_links/appointment.JPG') }}" alt="Patient Management">Doctors Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Create Schedule</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Create Schedule
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('save-schedule') }}" aria-label="{{ __('Create Schedule') }}">
                    @csrf
                    
                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Select Date') }}</label>
        
                        <div class="col-md-2">
                          <input id="date" onchange='no_weekends(this.value);getminutes();' min='{{date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))))}}' onkeydown="return false;"  name="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" type="date" >
                        </div>
                        <br>
                    </div>
                    <div class="form-group row">
                        <label for="from_time" class="col-md-4 col-form-label text-md-right">{{ __('From:') }}</label>
        
                        <div class="col-md-2">
                            <select name="from_time" id="from_time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" onchange="to_time_data(this.value);" required>
                                <option value="" selected disabled>-- Select Time --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="to_time" class="col-md-4 col-form-label text-md-right">{{ __('To:') }}</label>
    
                        <div class="col-md-2">
                            <select name="to_time" id="to_time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" required>
                                <option value="" selected disabled>-- Select Time --</option>
                            </select>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label  class="  col-form-label text-info">AM : <span id='available_am'>0</span> :  PM : <span id='available_pm'>0</span> </label>
                        </div> --}}
                    </div>
{{-- 
                    <div class="form-group row">
                        <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('Select Period:') }}</label>
                        <div class="col-md-6">
                            <select name="time" id="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" required>
                                <option value="" selected disabled>-- Select Period --</option>
                                <!-- <option  value="AM">Morning</option>
                                <option value="PM">Afternoon</option> -->
                            </select>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <div class="col-md-6">
                            
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-calendar"></i> Save Schedule</button>
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
            document.getElementById("myDiv").style.display="block";
            $.ajax({    
            
                type: "GET",
                url: "{{ url('check_schedule_doctor') }}",            
                data: {
                    "date" : value,
                }     ,
                dataType: "json",   
                success: function(data){ 
                    document.getElementById("myDiv").style.display="none";
                    console.log(data);
                    if(data.length != 0)
                    {
                        document.getElementById('date').value = "";
                        alert('You already have schedule for this date. Please choose another.');
                        return false;
                    }
                    var times = getminutes();
                    $(".time-data").remove();
                    $(".time-data-to").remove();
                    for(i = 0;i < times.length;i++)
                    {
                     
                        $("#from_time").append("<option class='time-data ' value='"+times[i]+"' >"+times[i]+"</option>");
                    }
                   
                },
                error: function(e)
                {
                    // document.getElementById("myDiv").style.display="none";
                    console.log(e);
                }
            });
        }
        
    }
    function reset_date()
    {
        document.getElementById('date').value = "";
    }
    function getminutes(start,end)
    {
        var x = 15; //minutes interval
        var times = []; // time array
        var tt = 540; // start time
        var ap = ['AM', 'PM']; // AM-PM

        //loop to increment the time and push results in array
        for (var i=0;tt<16.25*60; i++) {
        var hh = Math.floor(tt/60); // getting hours of day in 0-24 format
        var mm = (tt%60); // getting minutes of the hour in 0-55 format
        if(hh == 12)
        {
        times[i] = ("0" + (hh % 13)).slice(-2) + ':' + ("0" + mm).slice(-2) + " "+ ap[Math.floor(hh/12)]; // pushing data in array in [00:00 - 12:00 AM/PM format]
        }
        else
        {
        times[i] = ("0" + (hh % 12)).slice(-2) + ':' + ("0" + mm).slice(-2) + " "+ ap[Math.floor(hh/12)]; // pushing data in array in [00:00 - 12:00 AM/PM format]    
        }
        tt = tt + x;
        }
        return times;
    }
    function to_time_data(value)
    {
        $(".time-data-to").remove();
        document.getElementById('to_time').value = "";
        var times = getminutes();
        var index = times.findIndex((time) => time == value);

        for(i = index+1;i < times.length;i++)
        {
            
            $("#to_time").append("<option class='time-data-to ' value='"+times[i]+"' >"+times[i]+"</option>");
        }
    }
</script>
@include('layouts.dashboard.footer')
@endsection
