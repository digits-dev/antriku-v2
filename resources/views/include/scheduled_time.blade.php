<script>

    // Check if date is today
    function isDateToday(date) {
        const otherDate = new Date(date);
        const todayDate = new Date();
    
        if (
            otherDate.getDate() === todayDate.getDate() &&
            otherDate.getMonth() === todayDate.getMonth() &&
            otherDate.getYear() === todayDate.getYear()
        ) {
            return true;
        } else {
            return false;
        }
    }
    
    // Convert time to 12 hour format
    function to12HourFormat(date) {
      return {
        hours: ((date.getHours() + 11) % 12 + 1),
        meridian: (date.getHours() >= 12) ? 'PM' : 'AM',
      };
    }
    
    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }
    
    function getDateFromHours(time) {
        time = time.split(':');
        let now = new Date();
        return new Date(now.getFullYear(), now.getMonth(), now.getDate(), ...time);
    }
    
    function callTime() {
        $('#scheduled_time').html('<option value="" selected disabled>Loading..</option>');
        $('#scheduled_time').html('');
        $('#scheduled_time').html('<option value="" selected disabled>Select Time</option>');
        
        var date = new Date(); 
        var i;
        var time;
    
        $.ajax({
            url : "{{ route('get_time') }}",
            type : "GET" ,
            data : { branch: $('#branch_id').val(), date: $('#scheduled_date').val() },
            success : function (result) {
                console.log(result);
                const bookedTime = [];
                var myTime = '00:00:00';
                for(i=0; i<result.reservations.length; i++){
                    bookedTime.push(result.reservations[i].scheduled_time);
    
                    if(result.reservations[i].id == $('#header_id').val()){
                        myTime = result.reservations[i].scheduled_time;
                    }
                }
    
                var dd = result.date.mday;
                var mm = result.date.mon;
                var yyyy = result.date.year;
                var setDate = new Date(yyyy+"-"+mm+"-"+dd);
                var allTime = result.schedule[0].time.split(",");
    
                for(a=0; a < result.schedule.length; a++){
                    timeString = result.schedule[a].time;
                    const timeString12hr = new Date('1970-01-01T' + timeString + 'Z')
                    .toLocaleTimeString('en-US',
                        {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
                    );
    
                    const length = bookedTime.filter(time => time === timeString).length;
    
                    if(length >= 4 && myTime !== timeString){
                        var unavailable = 'data-toggle="tooltip" data-placement="top" title="This operating schedule is already booked." style="color:gray;" disabled';
                    }else{
                        var unavailable = '';
                    }
    
                    time = getDateFromHours(timeString).getHours();  
                    if (date.getHours() < time && isDateToday(setDate)) {
                        $('#scheduled_time').append('<option value="'+timeString+'" '+unavailable+'>'+timeString12hr+' ('+length+'/4)</option>');
                    }else if(isDateToday(setDate) == false){
                        $('#scheduled_time').append('<option value="'+timeString+'" '+unavailable+'>'+timeString12hr+' ('+length+'/4)</option>');
                    }
                }		
            }
        })
    }
    
    $( "#scheduled_date" ).change( function () {
        $('#scheduled_time').prop('disabled',false);
        $('#scheduled_time').html('');
        callTime();
    })
    
    </script>
    
    <?php 
       
        $ScheduledDate = DB::table('returns_appointment')->where('id',CRUDBooster::getCurrentId())->first();
        $dayname = date('l', strtotime($ScheduledDate->scheduled_date)); 
        $OperatingSched = DB::table('operating_schedule')->where('branch_id',$ScheduledDate->branch_id)
        ->where('day',$dayname)->where('status','ACTIVE')->get();
    
        // $t1 = strtotime($OperatingSched->start_time);
        // $t2 = strtotime($OperatingSched->end_time);
        // $diff = $t2 - $t1;
        // $hours = $diff / ( 60 * 60 );
    
        $AllAppointment = DB::table('returns_appointment')->where('scheduled_date',date('Y-m-d', strtotime($ScheduledDate->scheduled_date)))->get();
        $Booked = array();
        $myID = '00:00:00';
        foreach($AllAppointment as $appt){
            array_push($Booked,$appt->scheduled_time);
    
            if($appt->id == CRUDBooster::getCurrentId()){
                $myID = $appt->scheduled_time;
            }
        }
    ?>
    
    <div class="row">    
        <div class="col-md-8">
            <input type="hidden" id="header_id" value="{{CRUDBooster::getCurrentId()}}">
            <select name="scheduled_time" id="scheduled_time" class="form-control" required>
                @for($i=0; $i<=count($OperatingSched)-1; $i++)
                    <?php 
                        $time = $OperatingSched[$i]->time; 
    
                        if(date('h:i A', strtotime($time)) == date('h:i A', strtotime($ScheduledDate->scheduled_time))){
                            $isSelected = 'selected';
                        }else{
                            $isSelected = '';
                        }
                        $filtered_array = array_filter($Booked, function($t) use ($time){
                            return date('H:i:s', strtotime($time)) == $t;
                        });

                        $length = count($filtered_array);

                        if($length >= 4 && $myID != date('H:i:s', strtotime($time))){
                            $isDisabled = 'data-toggle='.'tooltip'.' data-placement='.'top'.' title='.'Reserved'.' style='.'color:gray'.' disabled';
                        }else{
                            $isDisabled = '';
                        }
                        
                        // if(in_array(date('H:i:s', strtotime($time)), $Booked) && $myID != date('H:i:s', strtotime($time))){
                        //     $book_count = '1';
                        // }else if(date('h:i A', strtotime($time)) == date('h:i A', strtotime($ScheduledDate->scheduled_time))){
                        //     $book_count = '1';
                        // }else{
                        //     $book_count = '0';
                        // }
                    ?>
                    <option value="{{ $time }}" {{ $isSelected }} {{$isDisabled}}>{{ date('h:i A', strtotime($time)) }} ({{$length}}/4)</option>
                @endfor
            </select>
        </div>
    </div>

</script>