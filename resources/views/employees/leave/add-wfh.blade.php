@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Work From Home</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">WFH</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Request Work From Home</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('employees.store.wfh') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>From <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control" name="from" required type="date" value="{{old('from')}}"min="{{ date('Y-m-d') }}" id="fromdate" max="{{ \Carbon\Carbon::now()->addDays(30)->toDateString()}}">
                                                @error('from')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>To <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input class="form-control " required name="to" type="date" id="todate" value="{{old('to')}}">
                                                @error('to')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Task<span class="text-danger">*</span></label>
                                    <textarea name="reason" required rows="4" class="form-control">{{old('reason')}}</textarea>
                                    @error('reason')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            Date.prototype.addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }

            $('#fromdate').change(function() {
                var myInput = document.getElementById('todate');
                var mindate = document.getElementById('fromdate').value;
                myInput.setAttribute('min', mindate);
                var myFutureDate = new Date(mindate);
                console.log(myFutureDate.getDate());
                myInput.setAttribute('max', myFutureDate.addDays(30).toISOString().split('T')[0]);
             
            })
        });
    </script>
@endpush
{{-- 

if ($request->from >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
    $leaveRecord = new Leaverecord();
    $leaveRecord->user_id = $userLeave->user_id;
    $leaveRecord->type_id = $userLeave->leaves_id;
    $leaveRecord->leave_id = $userLeave->id;
    $leaveRecord->from = $request->from;
    $leaveRecord->to = $request->to;
     //sunday and saturday count in request->from to request->to
     $day = Carbon::createFromFormat('Y-m-d', $request->from);
     $ssfrom = date('d',strtotime($day));
     $ssto = date('d',strtotime($request->to));
     $sunday = 0;
     $saturday = 0;          
     foreach(range($ssfrom,$ssto) as $key => $next) {
         if (strtolower($day->format('l')) == 'sunday') {
             $sunday++;
            }
            //saturday Count first And third
            $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
            $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
            if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d"))) {
                $saturday++;
            }
            $day = $day->addDays();
     }
     $days=$days-$sunday;
     $days=$days-$saturday;
     $hfrom=$request->from;
     $hto =$request->to;
     $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
     $days=$days-$holiday;
    $leaveRecord->day =$days;
    $leaveRecord->reason = $request->reason;
    $leaveRecord->status = 2;
    $leaveRecord->save();
} elseif ($request->from <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
    $lastMonthofDayD = Carbon::now()->endOfMonth();
    $diffDay = $dateFrom->diff($lastMonthofDayD);
    $diffDay = $diffDay->format('%a');
    $daysn = $diffDay + 1;
    $daysnl = $diffDay + 1;
    $leaveRecord = new Leaverecord();
    $leaveRecord->user_id = $userLeave->user_id;
    $leaveRecord->leave_id = $userLeave->id;
    $leaveRecord->type_id = $userLeave->leaves_id;
    $leaveRecord->from = $request->from;
    $leaveRecord->to = $lastMonthofDay;
    //sunday and saturady count function 
    $day = Carbon::createFromFormat('Y-m-d', $request->from);
    $ssfrom = date('d',strtotime($day));
    $ssto = date('d',strtotime($lastMonthofDay));
    $sunday = 0;
    $saturday = 0;
    foreach(range($ssfrom,$ssto) as $key => $next) {
        if (strtolower($day->format('l')) == 'sunday') {
            $sunday++;
        }
        //saturday Count first And third
        $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
        $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
        if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d"))) {
            $saturday++;
        }
        $day = $day->addDays();
    }
     $hfrom=$request->from;
     $hto=$lastMonthofDay;
     $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
     $daysn=$daysn-$sunday;
     $daysn=$daysn-$saturday;
     $daysn=$daysn-$holiday;
    $leaveRecord->day = $daysn;
    $leaveRecord->reason = $request->reason;
    $leaveRecord->status = 2;
    $leaveRecord->save();
    $NewRecord = $days - $daysnl;
    if ($NewRecord > 0) {
        $lastMonthofDays = Carbon::now()->endOfMonth();
        $fromNewDate = $lastMonthofDays->addDay(1)->toDateString();
        $newTodate= $request->to;              
        $leaveRecord = new Leaverecord();
        $leaveRecord->user_id = $userLeave->user_id;
        $leaveRecord->leave_id = $userLeave->id;
        $leaveRecord->type_id = $userLeave->leaves_id;
        $leaveRecord->from = $fromNewDate;
        $leaveRecord->to = $request->to;
           //sunday and saturady count function 
           $day = Carbon::createFromFormat('Y-m-d', $fromNewDate);
           $dayss = Carbon::createFromFormat('Y-m-d', $fromNewDate);
           $ssfrom = date('d',strtotime($day));
           $ssto = date('d',strtotime($request->to));
           $smonth = date('Y-m',strtotime($day));
           $sunday = 0;
           $saturday = 0;
           foreach(range($ssfrom,$ssto) as $key => $next) {
               if (strtolower($day->format('l')) == 'sunday') {
                   $sunday++;
                }
                //saturday Count first And third
                $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                $satn1 = Carbon::parse('first saturday of next month')->format('Y-m-d');
                $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
                if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d") || $satn3 == $day->format("Y-m-d") || $satn1 == $day->format("Y-m-d"))) {
                    $saturday++;
                }
                $day = $day->addDays();
            }
        $hfrom=$fromNewDate;
        $hto=$request->to;
        $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
        $NewRecord=$NewRecord-$sunday;
        $NewRecord=$NewRecord-$saturday;
        $NewRecord=$NewRecord-$holiday;
        $leaveRecord->day = $NewRecord;
        $leaveRecord->reason = $request->reason;
        $leaveRecord->status = 2;
        $leaveRecord->save();
    }
} elseif ($request->from > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {

    $leaveRecord = new Leaverecord();
    $leaveRecord->user_id = $userLeave->user_id;
    $leaveRecord->leave_id = $userLeave->id;
    $leaveRecord->type_id = $userLeave->leaves_id;
    $leaveRecord->from = $request->from;
    $leaveRecord->to = $request->to;
           //sunday and saturady count function 
           $day = Carbon::createFromFormat('Y-m-d', $request->from);
           $ssfrom = date('d',strtotime($day));
           $ssto = date('d',strtotime($request->to));
           $smonth = date('Y-m',strtotime($day));
           $sunday = 0;
           $saturday = 0;
           foreach(range($ssfrom,$ssto) as $key => $next) {
               if (strtolower($day->format('l')) == 'sunday') {
                   $sunday++;
                }
                //saturday Count first And third
                $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                $satn1 = Carbon::parse('first saturday of next month')->format('Y-m-d');
                $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
                if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d") || $satn3 == $day->format("Y-m-d") || $satn1 == $day->format("Y-m-d"))) {
                    $saturday++;
                }
                $day = $day->addDays();
            }
        //  dd($sunday,$saturday);
    $hfrom=$request->from;
    $hto=$request->to;
    $holiday= Holiday::where('status',1)->where(function($query)use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
    $days=$days-$sunday;
    $days=$days-$saturday;
    $days=$days-$holiday;
    $leaveRecord->day = $days;
    $leaveRecord->reason = $request->reason;
    $leaveRecord->status = 2;
    $leaveRecord->save();
} elseif ($request->from >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
    $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
    $diffDay = $dateFrom->diff($nextToMonthLastDayD);
    $diffDay = $diffDay->format('%a');
    $daysn = $diffDay + 1;
    // dd($daysn);
    $daysl = $diffDay + 1;
    $leaveRecord = new Leaverecord();
    $leaveRecord->user_id = $userLeave->user_id;
    $leaveRecord->type_id = $userLeave->leaves_id;
    $leaveRecord->leave_id = $userLeave->id;
    $leaveRecord->from = $request->from;
    $leaveRecord->to = $nextToMonthLastDayD;
      //sunday and saturady count function 
      $day = Carbon::createFromFormat('Y-m-d', $request->from);
      $ssfrom = date('d',strtotime($request->from));
      $ssto = date('d',strtotime($nextToMonthLastDayD));
      $smonth = date('Y-m',strtotime($day));
      $sunday = 0;
      $saturday = 0;
    //   dd($ssfrom,$ssto);
      foreach(range($ssfrom,$ssto) as $key => $next) {
          if (strtolower($day->format('l')) == 'sunday') {
              $sunday++;
           }
           $day = $day->addDays();
           //saturday Count first And third
           $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
           $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
           $satn1 = Carbon::parse('first saturday of next month')->format('Y-m-d');
           $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
           if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d") || $satn3 == $day->format("Y-m-d") || $satn1 == $day->format("Y-m-d"))) {
               $saturday++;
           }
       }
    //    dd($sunday,$saturday);
    $hfrom=$request->from;
    $hto=$nextToMonthLastDayD;
    $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
    $daysn=$daysn-$sunday;
    $daysn=$daysn-$saturday;
    $daysn=$daysn-$holiday;
    $leaveRecord->day = $daysn;
    $leaveRecord->reason = $request->reason;
    $leaveRecord->status = 2;
    $leaveRecord->save();
    $NewRecord = $days - $daysl;
    if ($NewRecord > 0) {
        $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2)->toDateString(); //last and 3 range month
        $leaveRecord = new Leaverecord();
        $leaveRecord->user_id = $userLeave->user_id;
        $leaveRecord->type_id = $userLeave->leaves_id;
        $leaveRecord->leave_id = $userLeave->id;
        $leaveRecord->from = $lastMonthofDays;
        $leaveRecord->to = $request->to;
        //sunday and saturady count function 
        $day = Carbon::createFromFormat('Y-m-d',$lastMonthofDays);
        $ssfrom = date('d',strtotime($day));
        $ssto = date('d',strtotime($request->to));
        $smonth = date('Y-m',strtotime($day));
        $sunday = 0;
        $saturday = 0;
        foreach(range($ssfrom,$ssto) as $key => $next) {
            if (strtolower($day->format('l')) == 'sunday') {
                $sunday++;
             }
             //saturday Count first And third
             $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
             $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
             $satn1 =Carbon::parse('first saturday of next month')->format('Y-m-d');
             $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
             $satn4 = Carbon::parse("first saturday of second month")->format("Y-m-d");
             $satn5 = Carbon::parse("third saturday of second month")->format("Y-m-d");
                 if (strtolower($day->format('l')) == 'saturday' && ($satn4 == $day->format("Y-m-d") || $satn5 == $day->format("Y-m-d"))) {
                     $saturday++;
                    }
                    $day = $day->addDays();
         }
        $hfrom=$lastMonthofDays;
        $hto=$request->to;
        $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();               
        $NewRecord=$NewRecord-$sunday;
        $NewRecord=$NewRecord-$saturday;
        $NewRecord=$NewRecord-$holiday;
        $leaveRecord->day = $NewRecord;
        $leaveRecord->reason = $request->reason;
        $leaveRecord->status = 2;
        $leaveRecord->save();
    }
} --}}