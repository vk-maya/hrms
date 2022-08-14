public function storeleave(Request $request){  
    $rules = [
        'type_id' => ['required', 'integer'],
        'from' => ['required', 'date'],
        'to' => ['required', 'date'],
        'reason' => ['required', 'string'],
    ];
    $date = date('Y-m-d', strtotime($request->from));
    $nowdate =date('Y-m-d', strtotime(now()));
    if($date<=$nowdate){
        return back()->withErrors(["from" => "Please Select From date"])->withInput();
    }
    if( date('Y-m-d', strtotime($request->to)) < $date){
        return back()->withErrors(["to" => "Please Select to date"])->withInput();
    }
    $request->validate($rules);
    $data = new Leave();
    $data->user_id =Auth::guard('web')->user()->id;
    $leavetype = settingleave::where('id',$request->type_id)->count();
        if($leavetype>0){
                // dd($leavetyp);
                $data->leaves_id =$request->type_id;
            }else{
                return back()->withErrors(["type_id" => "Please Select Leave Type"])->withInput(); 
            }
    $date = now();
        $fromdate=date( "Y-m-d",strtotime("$date + 30 day"));
        if($request->from <=$fromdate){
            $data->form = date('Y-m-d', strtotime($request->from));
            $todate = date( "Y-m-d",strtotime("$request->from + 30 day"));
            if($request->to <=$todate){
                $data->to = date('Y-m-d', strtotime($request->to));
            }else{
                return redirect()->back();
            }          
        }else{
            return redirect()->back();
        }      
    $leave = Leave::where('user_id',Auth::guard('web')->user()->id)->where(function($query) use($request){
        $query->whereBetween('form',[$request->from,$request->to])
        ->orWhereBetween('to',[$request->from,$request->to]);
    })->count();
    if($leave > 0){
        return back()->withErrors(["from" => "Please Select another From date"])->withInput();
    }
    $data->reason = $request->reason;
    $datetime1 = new DateTime($request->from);
    $datetime2 = new DateTime($request->to);
    $interval = $datetime1->diff($datetime2);
    $da = $interval->format('%a');
    $days = $da+1;
    $data->day =$days;
    $leavemonth = Leave::where('leaves_id',$request->type_id)->where('user_id',Auth::guard('web')->user()->id)->whereMonth('form', date('m'))->whereYear('form', date('Y'))->get();
    $start = date('Y-m-d', strtotime(Auth::guard('web')->user()->joiningDate));
    $end = date('Y-m-d');
    $interval = Carbon::parse($start)->DiffInMonths($end);
    $data->status =2;
    $data->save();
    
    $leavetable= Leave::where('user_id',Auth::guard('web')->user()->id)->latest()->first();

    $end=Carbon::parse($end)->endOfMonth(); ///curent month last date
    $end=date('Y-m-d',strtotime($end));
    
    $endn=Carbon::now()->addMonth(1);
    $endn=Carbon::parse($endn)->endOfMonth(); ///next month last date
    $endn=date('Y-m-d',strtotime($endn));
    
    $endnn=Carbon::now()->addMonth(2);
    $endnn=Carbon::parse($endnn)->endOfMonth(); ///next to next month last date
    $endnn=date('Y-m-d',strtotime($endnn));
            /*
            if ($request->to <= $end) {
                $leaverecord = new Leaverecord();
                $from=new DateTime($request->from);
                $endd=new DateTime($request->to);
                $daydiffer =$from->diff($endd);
                $daydiffer = $daydiffer->format('%a');
                $totalday = $daydiffer+1;     
                $leaverecord->from =$request->from;
                $leaverecord->to = $request->to;
                $leaverecord->day = $totalday;
                $leaverecord->reason = $leavetable->reason;
                $leaverecord->type_id = $leavetable->leaves_id;
                $leaverecord->user_id =Auth::guard('web')->user()->id;
                $leaverecord->status =2;
                $leaverecord->leave_id =$leavetable->id;
                $leaverecord->save();
            }elseif($request->from > $end && $request->to < $endn){
                $leaverecord = new Leaverecord();
                $from=new DateTime($request->from);
                $endd=new DateTime($request->to);
                $daydiffer =$from->diff($endd);
                $daydiffer = $daydiffer->format('%a');
                $totalday = $daydiffer+1;
                $leaverecord->from =$request->from;
                $leaverecord->to = $request->to;
                $leaverecord->day = $totalday;
                $leaverecord->reason = $leavetable->reason;
                $leaverecord->type_id = $leavetable->leaves_id;
                $leaverecord->user_id =Auth::guard('web')->user()->id;
                $leaverecord->status =2;
                $leaverecord->leave_id =$leavetable->id;
                $leaverecord->save();
            }elseif($request->from < $end && $request->to > $end){            
                $end=date('Y-m-d',strtotime($end));
                $endn=new DateTime($end);
                $froom=new DateTime($request->from);
                $daydiffer =$froom->diff($endn);
                $daydiffer = $daydiffer->format('%a');
                $totalday = $daydiffer+1;
                $nfrom =Carbon::parse($request->from)->addDays($daydiffer);
                $to = date('Y-m-d',strtotime($nfrom));
                $leaverecord = new Leaverecord();
                $leaverecord->from =$request->from;
                $leaverecord->to = $to;
                $leaverecord->day = $totalday;
                $leaverecord->reason = $leavetable->reason;
                $leaverecord->type_id = $leavetable->leaves_id;
                $leaverecord->user_id =Auth::guard('web')->user()->id;
                $leaverecord->status =2;
                $leaverecord->leave_id =$leavetable->id;
                $leaverecord->save();
                $day =$leavetable->day-$totalday;
                if ($day>1){
                    $from =Carbon::parse($request->from)->addDays($totalday);
                    $to =Carbon::parse($to)->addDays($day);
                    $leaverecord= new Leaverecord();
                    $leaverecord->from=$from;
                    $leaverecord->to=$to;
                    $leaverecord->day=$day;
                    $leaverecord->reason = $leavetable->reason;
                    $leaverecord->type_id = $leavetable->leaves_id;
                    $leaverecord->user_id =Auth::guard('web')->user()->id;
                    $leaverecord->status =2;
                    $leaverecord->leave_id =$leavetable->id;
                    $leaverecord->save();
                }   
            }elseif($request->from < $endn && $request->to > $endn){   
                $end=date('Y-m-d',strtotime($endn));
                $endn=new DateTime($end);
                $froom=new DateTime($request->from);
                $daydiffer =$froom->diff($endn);
                $daydiffer = $daydiffer->format('%a');
                $totalday = $daydiffer+1;
                $nfrom =Carbon::parse($request->from)->addDays($daydiffer);
                // dd($totalday,$nfrom);
                $to = date('Y-m-d',strtotime($nfrom));
                $leaverecord = new Leaverecord();
                $leaverecord->from =$request->from;
                $leaverecord->to = $to;
                $leaverecord->day = $totalday;
                $leaverecord->reason = $leavetable->reason;
                $leaverecord->type_id = $leavetable->leaves_id;
                $leaverecord->user_id =Auth::guard('web')->user()->id;
                $leaverecord->status =2;
                $leaverecord->leave_id =$leavetable->id;
                $leaverecord->save();
                $day =$leavetable->day-$totalday;
                if ($day>1){
                    $from =Carbon::parse($request->from)->addDays($totalday);
                    $to =Carbon::parse($to)->addDays($day);
                    $leaverecord= new Leaverecord();
                    $leaverecord->from=$from;
                    $leaverecord->to=$to;
                    $leaverecord->day=$day;
                    $leaverecord->reason = $leavetable->reason;
                    $leaverecord->type_id = $leavetable->leaves_id;
                    $leaverecord->user_id =Auth::guard('web')->user()->id;
                    $leaverecord->status =2;
                    $leaverecord->leave_id =$leavetable->id;
                    $leaverecord->save();
                }   
            }else{
                $leaverecord= new Leaverecord();
                $leaverecord->from=$leavetable->form;
                $leaverecord->to=$leavetable->to;
                $leaverecord->day=$leavetable->day;
                $leaverecord->reason = $leavetable->reason;
                $leaverecord->type_id = $leavetable->leaves_id;
                $leaverecord->user_id =Auth::guard('web')->user()->id;
                $leaverecord->status =2;
                $leaverecord->leave_id =$leavetable->id;
                $leaverecord->save();
            }*/
   

        $leave= Leave::latest()->first();
    
        $ltype = UserleaveYear::where('user_id',Auth::guard('web')->user()->id)->first();
        $jd =Auth::guard('web')->user()->joiningDate;
        $sess = Session::where('status',1)->latest()->first();    
        if ($jd >= $sess->from) {
            $jd =date('Y-m-d', strtotime(Auth::guard('web')->user()->joiningDate));
        }else{
            $jd =$sess->from;
            $jd =date('Y-m-d', strtotime($jd));
        }
        $nowdate =date('Y-m-d', strtotime(now()));
        $nextdate =date('Y-m-d', strtotime(now()->addMonth()));
        $remleave = UserleaveYear::where('user_id',Auth::guard('web')->user()->id)->first();
        $ltypeId = settingleave::find($leave->leaves_id);
        if ($ltypeId->type == "Annual") {
                    $diffr = round(Carbon::parse($jd)->floatDiffInMonths($nowdate));
                    $netl = $diffr-$remleave->netAnual;   
                    $nextdiffr = round(Carbon::parse($jd)->floatDiffInMonths($nextdate));
                    $netln = $nextdiffr-$remleave->netAnual;                
                    $dayss =$date->modify('last day of this month')->format('Y-m-d');
                    
                    if ($leave->day <= $netl && $netl >=1 ) {
                        $leavedata = new Leaverecord();
                        $leavedata->leave_id = $leave->id;
                        $leavedata->user_id =Auth::guard('web')->user()->id;
                        $leavedata->reason = $request->reason;
                        $leavedata->status =2;
                        $leavedata->type_id = $leave->leaves_id;
                        $leavedata->from = $leave->form;
                        $leavedata->to = $leave->to;
                        $leavedata->day = $leave->day;
                        $leavedata->save();
                    }elseif($request->to <= $dayss){
                        $data = $leave->day-$netl;                    
                        if ($netl>0){
                            $leavedata = new Leaverecord();
                            $leavedata->leave_id = $leave->id;
                            $leavedata->user_id =Auth::guard('web')->user()->id;
                            $leavedata->reason = $request->reason;
                            $leavedata->status =2;
                            $newDate = Carbon::parse($leave->form)->addDay($netl-1)->format('Y-m-d');
                            $leavedata->type_id = $leave->leaves_id;
                            $leavedata->from = $leave->form;
                            $leavedata->to = $newDate;
                            $leavedata->day = $netl;
                            $leavedata->save();
                        }
                        if ($data>=1){
                            // dd("222"); 
                            $leaver= Leaverecord::latest()->first();
                            if ($leave->id==$leaver->leave_id){                            
                                $leaver= Leaverecord::latest()->first();
                            }else{
                                $leaver= Leave::latest()->first();
                            }
                            $type = settingleave::where('type','Other')->first();
                            $leavedata = new Leaverecord();
                            $leavedata->leave_id = $leave->id;
                            $leavedata->user_id =Auth::guard('web')->user()->id;
                            $leavedata->status =2;
                            $leavedata->reason = $request->reason;
                            if ($leave->id==$leaver->leave_id){                            
                                $newDatefrom = Carbon::parse($leaver->to)->addDay(1)->format('Y-m-d');
                                $newDateto = Carbon::parse($leaver->to)->addDay($data)->format('Y-m-d');
                            }else{
                                $newDatefrom =$leaver->form;
                                $newDateto =$leaver->to;
                            }
                            $leavedata->type_id =$type->id;
                            $leavedata->from = $newDatefrom;
                            $leavedata->to = $newDateto;
                            $leavedata->day = $data;
                            $leavedata->save();
                                }
                    }elseif($leave->form < $dayss && $leave->to > $dayss){

                    }elseif($leave->form > $dayss && $leave->to>$dayss){
                        $datetime1 = new DateTime($request->from);
                        $datetime2 = new DateTime($request->to);
                        $interval = $datetime1->diff($datetime2);
                        $da = $interval->format('%a');
                        $days = $da+1;        
                        $data->day =$days;
                        dd($interval);
                        // $nextleave = 1/
                        $data =$leave->day-$netln;
                            if ($data>0){                            
                                    $leaver= Leave::latest()->first();
                                    $type = settingleave::where('type','Other')->first();                            
                                $leavedata = new Leaverecord();
                                $leavedata->leave_id = $leave->id;
                                $leavedata->user_id =Auth::guard('web')->user()->id;  
                                $leavedata->reason = $request->reason;      
                                $leavedata->status =2;
                                $newDate = Carbon::parse($leaver->form)->addDay($data)->format('Y-m-d');
                                $newDate = Carbon::parse($newDate)->addDay(-1)->format('Y-m-d');
                                $leavedata->type_id =$type->id;
                                $leavedata->from = $leaver->form;
                                $leavedata->to = $newDate;
                                $leavedata->day = $data ;
                                $leavedata->save();
                                
                            }
                            if ($netln>0){
                                $leaver= Leaverecord::latest()->first();
                                if ($leave->id==$leaver->leave_id){                            
                                    $leaver= Leaverecord::latest()->first();
                                }else{
                                    $leaver= Leave::latest()->first();
                                }
                                $leavedata = new Leaverecord();
                                $leavedata->leave_id = $leave->id;
                                $leavedata->user_id =Auth::guard('web')->user()->id;        
                                $leavedata->status =2;
                                $leavedata->reason = $request->reason;
                                if ($leave->id==$leaver->leave_id){                            
                                    $newDatefrom = Carbon::parse($leaver->to)->addDay(1)->format('Y-m-d');
                                    $newDateto = Carbon::parse($leaver->to)->addDay($netln)->format('Y-m-d');
                                }else{
                                    $newDatefrom =$leaver->form;
                                    $newDateto =$leaver->to;
                                }
                                $leavedata->type_id = $leave->leaves_id;
                                $leavedata->from = $newDatefrom;
                                $leavedata->to = $newDateto;
                                $leavedata->day = $netln;                    
                                $leavedata->save();
                                    }
                    }else{
                        $leaver= Leaverecord::latest()->first();
                            if ($leave->id==$leaver->leave_id){                            
                                $leaver= Leaverecord::latest()->first();
                            }else{
                                $leaver= Leave::latest()->first();
                            }
                            $type = settingleave::where('type','Other')->first();
                            $leavedata = new Leaverecord();
                            $leavedata->leave_id = $leave->id;
                            $leavedata->user_id =Auth::guard('web')->user()->id;        
                            $leavedata->status =2;
                            $leavedata->reason = $request->reason;
                            $leavedata->type_id = $leave->leaves_id;
                            $leavedata->from = $leave->form;
                            $leavedata->to = $leave->to;
                            $leavedata->day = $leave->day;
                            $leavedata->save();
                        }
        }elseif($ltypeId->type == "Sick"){
                $diffr = round(Carbon::parse($jd)->floatDiffInMonths($nowdate));            
                $sickd =$remleave->basicSick/12;
                $netsick=$diffr*$sickd;
                $netl = $netsick-$remleave->netSick;    
                $dayss =$date->modify('last day of this month')->format('Y-m-d');
                if ($leave->day <= $netl && $netl >=1 ) {
                    $leavedata = new Leaverecord();
                    $leavedata->leave_id = $leave->id;
                    $leavedata->user_id =Auth::guard('web')->user()->id;
                    $leavedata->status =2;
                    $leavedata->reason = $request->reason;
                    $leavedata->type_id = $leave->leaves_id;
                    $leavedata->from = $leave->form;
                    $leavedata->to = $leave->to;
                    $leavedata->day = $leave->day;
                    // dd($leavedata);
                    $leavedata->save();
                }elseif($request->to <= $dayss){
                    $data = $leave->day-$netl;            
                    if ($netl>0){
                        $leavedata = new Leaverecord();
                        $leavedata->leave_id = $leave->id;
                        $leavedata->user_id =Auth::guard('web')->user()->id;
                        $leavedata->reason = $request->reason;
                        $leavedata->status =2;
                        $newDate = Carbon::parse($leave->form)->addDay(round($netl-1))->format('Y-m-d');
                        $leavedata->type_id = $leave->leaves_id;
                        $leavedata->from = $leave->form;
                        $leavedata->to = $newDate;
                        $leavedata->day = $netl;
                        $leavedata->save();
                    }
                    if ($data>=1){
                        $cc= Leaverecord::count();
                        if ($cc>0) {
                            $leaver= Leaverecord::latest()->first();
                            if ($leave->id==$leaver->leave_id){                            
                                $leaver= Leaverecord::latest()->first();
                            }else{
                                $leaver= Leave::latest()->first();
                            }
                        }else{
                            $leaver= Leave::latest()->first();
                        }
                        $type = settingleave::where('type','Other')->first();
                        $leavedata = new Leaverecord();
                        $leavedata->leave_id = $leave->id;
                        $leavedata->user_id =Auth::guard('web')->user()->id;
                        $leavedata->reason = $request->reason;
                        $leavedata->status =2;
                        if ($leave->id==$leaver->leave_id){ 
                            if (is_int($data)){
                                $newDatefrom = Carbon::parse($leaver->to)->addDay(1)->format('Y-m-d');
                            }else{
                                $newDatefrom =$leaver->to;
                            }
                            $newDateto = Carbon::parse($leaver->to)->addDay($data)->format('Y-m-d');
                        }else{
                            $newDatefrom =$leaver->form;
                            $newDateto =$leaver->to;
                        }
                        $leavedata->type_id =$type->id;
                        $leavedata->from = $newDatefrom;
                        $leavedata->to = $newDateto;
                        $leavedata->day = $data;
                        $leavedata->save();
                            }
                }elseif($leave->form>$dayss && $leave->to>$dayss){
                    // $leaveNmonth =


                }elseif($leave->form<$dayss && $leave->to>$dayss){
                    $nextdiffr = round(Carbon::parse($jd)->floatDiffInMonths($nextdate));
                    $sickd =$remleave->basicSick/12;
                    $netsick=$nextdiffr*$sickd;
                    $netln = $netsick-$remleave->netSick;
                    $data =$leave->day-$netln;
                        if ($data>0){
                                $leaver= Leave::latest()->first();
                                $type = settingleave::where('type','Other')->first();                            
                            $leavedata = new Leaverecord();
                            $leavedata->leave_id = $leave->id;
                            $leavedata->user_id =Auth::guard('web')->user()->id;
                            $leavedata->reason = $request->reason;
                            $leavedata->status =2;
                            $newDate = Carbon::parse($leaver->form)->addDay($data)->format('Y-m-d');
                            $newDate = Carbon::parse($newDate)->addDay(-1)->format('Y-m-d');
                            $leavedata->type_id =$type->id;
                            $leavedata->from = $leave->form;
                            $leavedata->to = $leave;
                            $leavedata->day = $data ;
                            $leavedata->save();
                        }
                        if ($netln>0){
                            $cc= Leaverecord::count();
                        if ($cc>0) {
                            $leaver= Leaverecord::latest()->first();
                            if ($leave->id==$leaver->leave_id){                            
                                $leaver= Leaverecord::latest()->first();
                            }else{
                                $leaver= Leave::latest()->first();
                            }
                        }else{
                            $leaver= Leave::latest()->first();
                        }
                            $leavedata = new Leaverecord();
                            $leavedata->leave_id = $leave->id;
                            $leavedata->user_id =Auth::guard('web')->user()->id;        
                            $leavedata->status =2;
                            if ($leave->id==$leaver->leave_id){
                                $newDatefrom = Carbon::parse($leaver->to)->addDay(1)->format('Y-m-d');
                                $newDateto = Carbon::parse($leaver->to)->addDay($netln)->format('Y-m-d');
                            }else{
                                $newDatefrom =$leaver->form;
                                $newDateto =$leaver->to;
                            }
                            $leavedata->type_id = $leave->leaves_id;
                            $leavedata->from = $newDatefrom;
                            $leavedata->to = $newDateto;
                            $day=floor($netln * 2)/ 2;
                            $leavedata->day = $day;
                            $leavedata->save();
                        }
                }else{
                    $leaver= Leaverecord::latest()->first();
                        if ($leave->id==$leaver->leave_id){                            
                            $leaver= Leaverecord::latest()->first();
                        }else{
                            $leaver= Leave::latest()->first();
                        }
                        $type = settingleave::where('type','Other')->first();
                        $leavedata = new Leaverecord();
                        $leavedata->leave_id = $leave->id;
                        $leavedata->user_id =Auth::guard('web')->user()->id;
                        $leavedata->reason = $request->reason;
                        $leavedata->status =2;
                        $leavedata->type_id = $leave->leaves_id;
                        $leavedata->from = $leave->form;
                        $leavedata->to = $leave->to;
                        $leavedata->day = $leave->day;
                        $leavedata->save();
                    }
        }elseif($ltypeId->type == "Other"){
                $leavedata = new Leaverecord();
                $leavedata->leave_id = $leave->id;
                $leavedata->user_id =Auth::guard('web')->user()->id;
                $leavedata->reason = $request->reason;
                $leavedata->status =2;
                $leavedata->type_id = $leave->leaves_id;
                $leavedata->from = $leave->form;
                $leavedata->to = $leave->to;
                $leavedata->day = $leave->day;
                $leavedata->save();
        }else{
                $leavedata = new Leaverecord();
                $leavedata->leave_id = $leave->id;
                $leavedata->user_id =Auth::guard('web')->user()->id;
                $leavedata->reason = $request->reason;
                $leavedata->status =2;
                $leavedata->type_id = $leave->leaves_id;
                $leavedata->from = $leave->form;
                $leavedata->to = $leave->to;
                $leavedata->day = $leave->day;
                $leavedata->save();
        }
        return redirect()->route('employees.leave');
    }
 