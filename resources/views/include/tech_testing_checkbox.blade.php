
<?php 
    $ModelGroup = DB::table('model_group')->get();
    $CurrentModelGroup =  DB::table('tech_testing')->where('id',CRUDBooster::getCurrentId())->select('model_group_id')->first();
    $mg_array = array_map('intval', explode(',', $CurrentModelGroup->model_group_id));
?>
@foreach($ModelGroup as $key=>$mg)
    <div class="row">    
        <div class="col-md-12">
            <input type="checkbox" name="model_group_id[]" value="{{$mg->id}}" {{ in_array($mg->id, $mg_array) ? 'checked' : ''}}> {{$mg->model_group_name}}</span>
        </div>
    </div>
@endforeach