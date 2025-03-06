
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
function addDays(date, days) {
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

$(function(){
    var min_dtToday = new Date();
    var min_month = min_dtToday.getMonth() + 1;
    var min_day = min_dtToday.getDate();   
    var min_year = min_dtToday.getFullYear();
    if(min_month < 10)
        min_month = '0' + min_month.toString();
    if(min_day < 10)
        min_day = '0' + min_day.toString();
    var minDate = min_year + '-' + min_month + '-' + min_day;   
    
    
    var max_dtToday = addDays(minDate, 6);
    var max_month = max_dtToday.getMonth() + 1;
    var max_day = max_dtToday.getDate(); 
    var max_year = max_dtToday.getFullYear();
    if(max_month < 10)
        max_month = '0' + max_month.toString();
    if(max_day < 10)
        max_day = '0' + max_day.toString();
    var maxDate = max_year + '-' + max_month + '-' + max_day;   
    
    $('#scheduled_date').attr('min', minDate).attr('max', maxDate);
});

</script>

<?php 
    $ScheduledDate =  DB::table('returns_appointment')->where('id',CRUDBooster::getCurrentId())->value('scheduled_date'); 
    // $dateVal = date("m/d/Y", strtotime($ScheduledDate)).' ('.date('l', strtotime($ScheduledDate)).')';
?> 

<div class="row">    
    <div class="col-md-8">
        <input type="date" id="scheduled_date" name="scheduled_date" value="{{ date('Y-m-d', strtotime($ScheduledDate)) }}" class="form-control" required/>
    </div>
</div>


