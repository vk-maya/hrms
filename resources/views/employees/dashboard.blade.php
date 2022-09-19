@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
                <div class="welcome-img">
                    <a href="{{ route('employees.add.moreinfo') }}">
                        <img alt="" src="@if (Auth::guard('web')->user()->image != null) {{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif">
                    </a>
                    {{Auth::guard('web')->user()->first_name.' '.Auth::guard('web')->user()->last_name}}
                </div>
        <div class="row justify-content-center">
            <div class="col-md-3                                                ">
                <div class="stats-box text-center">
                    <p>Today Date</p>
                    {{ \Carbon\Carbon::now()->format('d-m-Y (l)') }}
                </div>
            </div>
            <div class="col-md-3">
                @if (isset($attendance) && $attendance->out_time != "00:00:00")
                @php
                $tt = \Carbon\Carbon::create($attendance->in_time)->diff($attendance->out_time);
                @endphp
                <div class="stats-box text-center">
                    <p>Working Time</p>
                    <label>{{ \Carbon\Carbon::createFromTime($tt->h,$tt->i,$tt->s)->format('h:i:s') }}</label>
                </div>
                @else
                <div class="stats-box text-center">
                    <p>Working Time</p> <label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
                </div>
                @endif
            </div>

            <div class="col-md-2">
                <div class="stats-box text-center">
                    <p>In Time</p>
                    @if (isset($attendance) && ($attendance->attendance = 'P'))
                    <h6>{{ \Carbon\Carbon::parse($attendance->in_time)->format('H:i A') }}</h6>
                    @else
                    <h6>00:00</h6>
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-box text-center">
                    <p>Out Time</p>
                    @if (isset($attendance) && $attendance->attendance == 'P' && $attendance->out_time != "00:00:00")
                    <h6>{{ \Carbon\Carbon::parse($attendance->out_time)->format('H:i A') }}</h6>
                    @else
                    <h6>00:00</h6>
                    @endif
                </div>
            </div>
            </div>
            <div class="row mt-3">
            <div class="col-md-6">
                <section class="dash-section">
                    <h1 class="dash-sec-title">Today</h1>
                    <div class="dash-sec-content">
                        <div class="dash-info-list">
                            @if ($data > 0)
                            <span class="dash-card text-success">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-check-circle"></i>
                                        <div class="dash-card-content">
                                            <p>Today Task Submit</p>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            @else
                            <a href="{{ route('employees.daily.task') }}" class="dash-card text-danger">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                    <i class="far fa-hourglass"></i>
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
                                        <p> {{ \Carbon\Carbon::parse($holi->date)->format('d M Y (l)') }} -
                                            {{ $holi->holidayName }}
                                        </p>
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
    </div>
</div>
</div>
@if(isset($attendance) && $attendance->in_time != "00:00:00")
@php
$diff = \Carbon\Carbon::create($attendance->in_time)->diffInSeconds(now()->toTimeString());
@endphp
@endif
@endsection
@push('js')
@if(isset($attendance) && $attendance->in_time != "00:00:00")
<script>
    $(document).ready(function() {
        var hoursLabel = document.getElementById("hours");
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var totalSeconds = {
            {
                $diff
            }
        };
        setInterval(setTime, 1000);

        function setTime() {
            ++totalSeconds;
            secondsLabel.innerHTML = pad(totalSeconds % 60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60) % 60);
            hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600));
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }
    });
</script>
@endif

@endpush