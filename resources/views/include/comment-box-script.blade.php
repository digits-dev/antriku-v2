
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
    const chatMessages = document.querySelector('.chat-messages');
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
                        showData[i] = `
                                        <div class="message user">
                                            <div class="message-content">
                                                <span>
                                                    <img src="${image}" alt="Avatar" style="border-radius:30%;width:30px;margin-bottom: 4px;">
                                                    <b>${result[i].name} (${result[i].role})</b>
                                                </span>
                                                <p>${result[i].comment}</p>
                                            </div>
                                            <div class="message-time">${result[i].comment_date}</div>
                                        </div>
                                    `;
                    }else{
                        showData[i] = `
                                        <div class="message agent">
                                            <div class="message-content">
                                                <span>
                                                    <img src="${image}" alt="Avatar" style="border-radius:30%;width:30px;margin-bottom: 4px;">
                                                    <b>${result[i].name} (${result[i].role})</b>
                                                </span>
                                                <p>${result[i].comment}</p>
                                            </div>
                                            <div class="message-time">${result[i].comment_date}</div>
                                        </div>
                                    `;  
                    }
                }
                $("#comment").val('');
                jQuery(".chat-messages").html(showData);   
                scrollToBottom();           
            }
        });
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}
</script>