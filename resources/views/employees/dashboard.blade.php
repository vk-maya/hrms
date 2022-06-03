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
                        <div class="welcome-img">
                            <a href="{{ route('employees.add.moreinfo') }}">
                                <img alt=""
                                    src="@if (Auth::guard('web')->user()->image != null) {{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif">
                            </a>
                        </div>
                        <div class="welcome-det">
                            <h3>{{ Auth::guard('web')->user()->first_name }}</h3>
                            <p>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
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
                            @if (isset($holi)&& $holi->date != "")
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
                        <h5 class="card-title">Timesheet <small
                                class="text-muted">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</small>
                        </h5>
                        <div class="punch-det">
                            <h6>Punch In at</h6>
                            @if (isset($attendance) && $attendance->attendance == 'P')
                                <p>{{ date('l', strtotime($attendance->date)) }}
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}
                                    {{ $attendance->in_time }}</p>
                            @else
                                <span class="dash-card text-danger">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <div class="dash-card-content">
                                                <div class="dash-card-content">
                                                    <p class="text-danger"><i
                                                            class="fa fa-hourglass-o text-danger"></i> You haven't
                                                        submitted the Puch today</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            @endif
                        </div>
                        <div class="punch-info">
                            <div class="punch-hours container">
                                <h1></h1>
                            </div>
                        </div>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box">
                                        <p>In Time</p>
                                        @if (isset($attendance) && ($attendance->attendance = 'P'))
                                            <h6>{{ $attendance->in_time }}</h6>
                                        @else
                                            <h6>00:00:00</h6>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box">
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
                </div>
            </div>
            {{-- <div class="col-md-4">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>Today <strong>3.45 <small>/ 8 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 31%"
                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Week <strong>28 <small>/ 40 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 31%"
                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Month <strong>90 <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 62%"
                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 62%"
                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Overtime <strong>4</strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 22%"
                                            aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            <div class="col-md-6">
                <div class="card recent-activity">
                    <div class="card-body">
                        <h5 class="card-title">Notification News</h5>
                            <ul class="res-activity-list">
                                @foreach ($allatendance as $item)
                                    @if ($item->date == \Carbon\Carbon::now()->format('Y-m-d'))
                                        <li>
                                            <p class="mb-0">Punch In at</p>
                                            <p class="res-activity-time">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $item->in_time }}
                                            </p>
                                        </li>
                                        <li>
                                            <p class="mb-0">Punch Out at</p>
                                            <p class="res-activity-time">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $item->out_time }}
                                            </p>
                                        </li>
                                    @endif
                                @endforeach
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
