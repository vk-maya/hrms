@extends('layouts.app')
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
                        <h1 class="dash-sec-title"></h1>
                        <div class="dash-sec-content">
                            <div class="dash-info-list">
                                    <a href="{{ route('employees.daily.task') }}" class="dash-card text-danger">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-hourglass-o"></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <h4 class="holiday-title mb-0"> <b>{{$holi->holidayName}}</b> {{\Carbon\Carbon::parse($holi->date)->format('d-m-Y')}} {{date("l",strtotime($holi->date))}}</h4>

                                            </div>
                                        </div>
                                    </a>
                            </div>
                        </section>
            </div>
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
            </div>
            
        <div class="row">
            <div class="col-md-4">
                <div class="card punch-status">
                    <div class="card-body">
                        <h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small>
                        </h5>
                        <div class="punch-det">
                            <h6>Punch In at</h6>
                            <p>Wed, 11th Mar 2019 10.00 AM</p>
                        </div>
                        <div class="punch-info">
                            <div class="punch-hours">
                                <span>3.45 hrs</span>
                            </div>
                        </div>
                        <div class="punch-btn-section">
                            <button type="button" class="btn btn-primary punch-btn">Punch Out</button>
                        </div>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box">
                                        <p>Break</p>
                                        <h6>1.21 hrs</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box">
                                        <p>Overtime</p>
                                        <h6>3 hrs</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
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
            </div>
            <div class="col-md-4">
                <div class="card recent-activity">
                    <div class="card-body">
                        <h5 class="card-title">Today Activity</h5>
                        <ul class="res-activity-list">
                            <li>
                                <p class="mb-0">Punch In at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    10.00 AM.
                                </p>
                            </li>
                            <li>
                                <p class="mb-0">Punch Out at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    11.00 AM.
                                </p>
                            </li>
                            <li>
                                <p class="mb-0">Punch In at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    11.15 AM.
                                </p>
                            </li>
                            <li>
                                <p class="mb-0">Punch Out at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    1.30 PM.
                                </p>
                            </li>
                            <li>
                                <p class="mb-0">Punch In at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    2.00 PM.
                                </p>
                            </li>
                            <li>
                                <p class="mb-0">Punch Out at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    7.30 PM.
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
