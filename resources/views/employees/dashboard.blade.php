@extends('layouts.app')
@push('css')
    <style>
        .container {
            /* width: 20px; */
            height: 300px;
            background: rgb(22, 22, 22);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: rgb(63, 252, 63) 10px solid;
        }

        /* .animate{
                                border:  rgb(245, 39, 32) 10px solid;
                            } */
        .container h1 {
            font-weight: 200;
            font-size: 25px;
            color: black;
        }

    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-box">
                        <div class="col-md-6">
                            <div class="welcome-img">
                                <a href="{{ route('employees.add.moreinfo') }}">
                                    <img alt=""
                                        src="@if (Auth::guard('web')->user()->image != null) {{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif">
                                </a>
                                {{ Auth::guard('web')->user()->first_name }}
                            </div>
                        </div>                        
                            <div class="col-md-2">
                                <div class="stats-box text-center">
                                    <p>Timesheet</p>
                                    {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stats-box text-center">
                                    <p>In Time</p>
                                    @if (isset($attendance) && ($attendance->attendance = 'P'))
                                        <h6>{{ $attendance->in_time }}</h6>
                                    @else
                                        <h6>00:00:00</h6>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="stats-box text-center">
                                    <p>Out Time</p>
                                    @if (isset($attendance) && $attendance->attendance == 'P')
                                        <h6>{{ $attendance->out_time }}</h6>
                                    @else
                                        <h6>00:00:00</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <section class="dash-section">
                        <h1 class="dash-sec-title">Today</h1>
                        <div class="dash-sec-content">
                            <div class="dash-info-list">
                                @if ($data > 0)
                                    <span class="dash-card text-success">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                <div class="dash-card-content">
                                                    <div class="dash-card-content">
                                                        <p>Today Task Submit</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                @else
                                    <a href="{{ route('employees.daily.task') }}" class="dash-card text-danger">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-hourglass-o"></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <p>You haven't submitted the task today</p>
                                            </div>
                                        </div>
                                    </a>
                                @endisset
                        </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="dash-section">
                    <h1 class="dash-sec-title">UPCOMING HOLIDAY</h1>
                    <div class="dash-sec-content">
                        <div class="dash-info-list">
                            @if (isset($holi) && $holi->date != '')
                                <span class="dash-card text-success">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-sun-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <p> {{ date('l', strtotime($holi->date)) }}
                                                {{ \Carbon\Carbon::parse($holi->date)->format('d-m-Y') }}
                                                {{ $holi->holidayName }}</p>
                                        </div>
                                    </div>
                                </span>
                            @else
                                <span class="dash-card text-info">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-sun-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <p>Holiday Comming Soon....</p>
                                        </div>
                                    </div>
                                </span>
                            @endif
                        </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card punch-status">
                    <div class="card-body">
                        <h5 class="card-title">NEXT SEVEN DAYS <small
                                class="text-muted"></small>
                        </h5>         
                      
                        
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="col-md-6">
                <div class="card recent-activity">
                    <div class="card-body">
                        <h5 class="card-title">Notification News</h5>
                        <ul class="res-activity-list">
                          
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
<script>
    const container = document.querySelector('.container');
    const h1 = document.querySelector('.container h1');

    // The clock function.
    const clock = () => {
        //   Accessing the date object.
        const date = new Date();
        let hours = date.getHours();
        let minutes = date.getMinutes();

        //   Adding a zero to the left of the time if it's less or equal than 9.
        if (+hours <= 9) {
            hours = '0' + hours;
        }
        if (+minutes <= 9) {
            minutes = '0' + minutes;
        }

        // adding the time to the h1 element.
        h1.innerHTML = hours + ':' + minutes;

        //   Toggling the animate class.
        container.classList.toggle('animate');
    }

    // calling the clock function after each second(1000ms).
    setInterval(clock, 1000);
</script>
@endpush
