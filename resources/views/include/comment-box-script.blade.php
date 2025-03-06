
<script type="text/javascript">
var pause = false;
// press enter key to submit comment 
$('#comment').keypress(function(e) {
    
    if(e.keyCode == 13){
        
        $("#clickSubmit").off('click');
        setTimeout(function() {
            $('#clickSubmit').click();
        }, 1000);
        return false;
    }
});

// Function for validating null or empty value
function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}

// for comments
function AllComments()
{
    document.getElementById("clickSubmit").disabled = true;
    setTimeout(function() {
        document.getElementById("clickSubmit").disabled = false;
    }, 1000);

    var comment = document.getElementById("comment").value; 
    var transaction_comment_id = document.getElementById("transaction_comment_id").value; 
    if(isEmptyOrSpaces(comment) == false)
    {
        $.ajax
        ({ 
            url: "{{ route('all-comment') }}",
            type: "POST",
            data: {
                'comment': comment,
                'id': transaction_comment_id,
                _token: '{!! csrf_token() !!}'
                },
            success: function(result)
            {
                
                var i;
                var showData = [];
                var image;
                for (i = 0; i < result.length; ++i) 
                {
                    image = "{{ URL::to('/') }}/" + result[i].userimg;
                    if(result[i].userid == '{{CRUDBooster::myId()}}')
                    {
                        showData[i] = '<div class="row">' +
                        
                            '<div class="col" style="float:right;align-self:end;">' +
                            '<img src="'+ image +'" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-left: 10px;">' +
                            '</div>' +
                            '<div class="col-12 ">' +
                            '<div class="comment-cloud" style="float:right;align-self:end;">' +
                            '<div class="row comment-date">' +
                            '<span><b>' + result[i].name + ' ('+ result[i].role +')</b> commented</span>' +
                            '<span style="float:right;font-weight: bolder;">' + result[i].comment_date +'</span>' +
                            '</div>' +
                            '<p>' + result[i].comment + '</p>' +
                            '</div>' +
                            '</div>' + '</div>' ;   
                    }else{
                        showData[i] = '<div class="row">' +
                        
                            '<div class="col" style="float:left;align-self:start;">' +
                            '<img src="'+ image +'" alt="Avatar" style="border-radius:50%;width:30px;margin-top:13px;margin-right: 10px;">' +
                            '</div>' +
                            '<div class="col-12 ">' +
                            '<div class="comment-cloud" style="float:left;align-self:start;">' +
                            '<div class="row comment-date">' +
                            '<span><b>' + result[i].name + ' ('+ result[i].role +')</b> commented</span>' +
                            '<span style="float:right;font-weight: bolder;">' + result[i].comment_date +'</span>' +
                            '</div>' +
                            '<p>' + result[i].comment + '</p>' +
                            '</div>' +
                            '</div>' + '</div>' ;   
                    }
                }

                $("#comment").val('');
                jQuery("#comment-area").html(showData);              
            }
        });
    }
}
</script>