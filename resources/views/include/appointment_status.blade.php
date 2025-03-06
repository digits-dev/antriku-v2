
<?php 
   $ScheduledAppointment = DB::table('returns_appointment')->where('id',CRUDBooster::getCurrentId())->first();
?>

<!-- <div class="row">    
    <div class="col-md-3">
		<input type="radio" id="action" name="action" class="action" value="SAVE ONLY" checked>
		&nbsp;<label>SAVE ONLY</label><br>
    </div>
	<div class="col-md-3">
		<input type="radio" id="action" name="action" class="action" value="CHANGE STATUS">
		&nbsp;<label>CHANGE STATUS</label><br>
    </div>
	<div class="col-md-3"></div>
</div>
<br> -->

<div class="row status_text_div">    
    <div class="col-md-8">
		<input type="text" id="appointment_status" name="appointment_status" class="form-control appointment_status" value="{{ $ScheduledAppointment->appointment_status }}" required readonly>
    </div>
</div>

<div class="row status_select_div">    
    <div class="col-md-8">
        <select name="appointment_status" id="appointment_status" class="form-control appointment_status" required>
			<option value="" disabled selected>Select status here...</option>
			<option value="BOOKED" {{ $ScheduledAppointment->appointment_status == 'BOOKED' ? 'selected':'' }}>BOOKED</option>
			<option value="ARRIVED" {{ $ScheduledAppointment->appointment_status == 'ARRIVED' ? 'selected':'' }}>ARRIVED</option>
			<option value="NO SHOW" {{ $ScheduledAppointment->appointment_status == 'NO SHOW' ? 'selected':'' }}>NO SHOW</option>
			<option value="CANCELLED" {{ $ScheduledAppointment->appointment_status == 'CANCELLED' ? 'selected':'' }}>CANCELLED</option>
        </select>
    </div>
</div>

<script>
	
$('.status_text_div').css("display", "block");
$('.status_select_div').css("display", "none");

$( ".action" ).change( function () {
	var action = $('input[class="action"]:checked').val();
	if(action === 'SAVE ONLY'){
		$('.status_text_div').css("display", "block");
		$('.status_select_div').css("display", "none");
	}else if(action === 'CHANGE STATUS'){
		$('.status_text_div').css("display", "none");
		$('.status_select_div').css("display", "block");
	}
})

</script>

