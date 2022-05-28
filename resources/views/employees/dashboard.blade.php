@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-box">
                        <div class="welcome-img">
                            <a href="{{route('employees.add.moreinfo')}}">
                            <img alt="" src="@if(Auth::guard('web')->user()->image != NULL){{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}@else{{ asset('storage/uploads/avtar.jpg')}}@endif">
                        </a>
                        </div>
                        <div class="welcome-det">
                            <h3>{{ Auth::guard('web')->user()->first_name }}</h3>
                            <p>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                        </div>
                    </div>
                </div>              
            </div>
           
            @if (count($data->toArray()))
                @php
                    $nowd = \Carbon\Carbon::now()->format('d/m/Y');
                    $postdate = $data[0]->orderBy('post_date', 'desc')->first()->post_date;
                    $pdate = \Carbon\Carbon::parse($postdate)->format('d/m/Y');
                @endphp
            @endif
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <section class="dash-section">
                        <h1 class="dash-sec-title">Today</h1>
                        <div class="dash-sec-content">
                            <div class="dash-info-list">
                                @if (count($data->toArray()) > 0 && $pdate == $nowd)
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
                    </div>
                </section>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="dash-sidebar">
                    <section>
                        <h5 class="dash-title">Projects</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>71</h4>
                                        <p>Total Tasks</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>14</h4>
                                        <p>Pending Tasks</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <div class="dash-stats-list">
                                        <h4>2</h4>
                                        <p>Total Projects</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h5 class="dash-title">Your Leave</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>4.5</h4>
                                        <p>Leave Taken</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>12</h4>
                                        <p>Remaining</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <a class="btn btn-primary" href="#">Apply Leave</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h5 class="dash-title">Your time off allowance</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>5.0 Hours</h4>
                                        <p>Approved</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>15 Hours</h4>
                                        <p>Remaining</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <a class="btn btn-primary" href="#">Apply Time Off</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h5 class="dash-title">Upcoming Holiday</h5>
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="holiday-title mb-0">Mon 20 May 2019 - Ramzan</h4>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
