<div class="row" style="background:#595959;color:white;padding:3px;text-align: center;">
    <h4>Comments</h4>   
</div> 

@if(request()->segment(3) == "detail" && CRUDBooster::getModulePath() != "transaction_history")
<div class="row comment-col" style="height:377px !important;"> 

    @if(count($data['Comment']) > 0)
        @foreach($data['Comment'] as $comment)
            @if($comment->userid == CRUDBooster::myId())     
                <div class="row">
                    <div class="col"  style="float:right;align-self:end;">
                        <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-left: 10px;">
                    </div>
                    <div class="col-12 ">
                        <div class="comment-cloud" style="float:right;align-self:end;">
                            <div class="row comment-date">
                                <span><b>{{ $comment->name }} ({{ $comment->role }})</b> commented</span>
                                <span style="float:right;font-weight: bolder;">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</span>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col" style="float:left;align-self:start;">
                        <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-right: 10px;">
                    </div>
                    <div class="col-12">
                        <div class="comment-cloud" style="float:left;align-self:start;">
                            <div class="row comment-date">
                                <span><b>{{ $comment->name }} ({{ $comment->role }})</b> commented</span>
                                <span style="float:right;font-weight: bolder;">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</span>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="row no-comment">
            <h4>No Comments Yet</h4>
            <p>Be the first to comment.</p>
        </div>
    @endif
</div>
@elseif(request()->segment(3) == "getDetailView" && CRUDBooster::getModulePath() == "transaction_history")
<div class="row comment-col" style="height:377px !important;"> 

    @if(count($Comment) > 0)
        @foreach($Comment as $comment)
            @if($comment->userid == CRUDBooster::myId())     
                <div class="row">
                    <div class="col"  style="float:right;align-self:end;">
                        <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-left: 10px;">
                    </div>
                    <div class="col-12 ">
                        <div class="comment-cloud" style="float:right;align-self:end;">
                            <div class="row comment-date">
                                <span><b>{{ $comment->name }} ({{ $comment->role }})</b> commented</span>
                                <span style="float:right;font-weight: bolder;">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</span>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col" style="float:left;align-self:start;">
                        <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-right: 10px;">
                    </div>
                    <div class="col-12">
                        <div class="comment-cloud" style="float:left;align-self:start;">
                            <div class="row comment-date">
                                <span><b>{{ $comment->name }} ({{ $comment->role }})</b> commented</span>
                                <span style="float:right;font-weight: bolder;">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</span>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="row no-comment">
            <h4>No Comments Yet</h4>
            <p>Be the first to comment.</p>
        </div>
    @endif
</div>
<div class="row" style=" height: auto;">
    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
    <input type="hidden" value="{{$transaction_details->header_id}}" name="transaction_comment_id" id="transaction_comment_id">
    <textarea type="input" name="comment" id="comment" placeholder="Type your comment here" class="form-control fixed-textarea" autocomplete="off" required></textarea>
    <button type="submit" value="Submit" onclick="AllComments()" id="clickSubmit" style="margin-top: 3px;" class="btn btn-success pull-right">Comment</button> 
</div>
@elseif(request()->segment(3) == "edit" || CRUDBooster::getModulePath() == "transaction_history")
<div class="row comment-col" id="comment-area" style="background-color:#EDEDED;">  
    @if(!empty($data['Comment']))
        @foreach($data['Comment'] as $comment)
            @if($comment->userid == CRUDBooster::myId())
                <div class="row">
                    <div class="col"  style="float:right;align-self:end;">
                        <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-left: 10px;">
                    </div>
                    <div class="col-12 ">
                        <div class="comment-cloud" style="float:right;align-self:end;">
                            <div class="row comment-date">
                                <span><b>{{ $comment->name }} ({{ $comment->role }})</b> commented</span>
                                <span style="float:right;font-weight: bolder;">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</span>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col" style="float:left;align-self:start;">
                        <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-right: 10px;">
                    </div>
                    <div class="col-12">
                        <div class="comment-cloud" style="float:left;align-self:start;">
                            <div class="row comment-date">
                                <span><b>{{ $comment->name }} ({{ $comment->role }})</b> commented</span>
                                <span style="float:right;font-weight: bolder;">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</span>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="row no-comment">
            <h4>No Comments Yet</h4>
            <p>Be the first to comment.</p>
        </div>
    @endif
</div>
<div class="row" style=" height: auto;">
    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
    <input type="hidden" value="{{$transaction_details->header_id}}" name="transaction_comment_id" id="transaction_comment_id">
    <textarea type="input" name="comment" id="comment" placeholder="Type your comment here" class="form-control fixed-textarea" autocomplete="off" required></textarea>
    <button type="submit" value="Submit" onclick="AllComments()" id="clickSubmit" style="margin-top: 3px;" class="btn btn-success pull-right">Comment</button> 
</div>
@endif

@push('bottom')
@include('include.comment-box-script')
@endpush