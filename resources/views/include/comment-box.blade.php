<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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


<div class="chat-container">
    <!-- Chat bubble that shows when chat is closed -->
    <div class="chat-bubble">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="chat-icon">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
      </svg>
    </div>

    <!-- Chat window that shows when chat is open -->
    <div class="chat-window">
        
      <div class="chat-header">
        <div class="chat-header-info">
          <div class="chat-avatar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>
          <div class="chat-title">
            <h3>Comments</h3>
            <p>Please Read or Enter comments here.</p>
          </div>
        </div>
        <div class="chat-actions">
          <!-- Theme toggle button -->
          <button class="theme-toggle" aria-label="Toggle dark mode">
            <!-- Sun icon for dark mode -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sun-icon">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
            <!-- Moon icon for light mode -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="moon-icon" style="display: none;">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>
          <button class="chat-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <div class="chat-messages">
        @if(count($Comment) > 0)
            @foreach($Comment as $comment)
            @if($comment->userid == CRUDBooster::myId())
                <div class="message user">
                    <div class="message-content">
                        <span>
                            <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:30%;width:30px;margin-bottom: 4px;">
                            <b>{{ $comment->name }} ({{ $comment->role }})</b>
                        </span>
                        <p>{{$comment->comment}}</p>
                    </div>
                    <div class="message-time">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</div>
                </div>
            @else
                <div class="message agent">
                    <div class="message-content">
                        <span>
                            <img src="{{ URL::to('/') }}/{{$comment->userimg}}" alt="Avatar" style="border-radius:30%;width:30px;margin-bottom: 4px;">
                            <b>{{ $comment->name }} ({{ $comment->role }})</b>
                        </span>
                        <p>{{$comment->comment}}</p>
                    </div>
                    <div class="message-time">{{ date('F j, Y h:i:A', strtotime($comment->comment_date)) }}</div>
                </div>
            @endif
            @endforeach
        @endif
        {{-- <div class="message agent">
          <div class="message-content">
            <p>Of course! I'd be happy to help. What would you like to know about our services?</p>
          </div>
          <div class="message-time">10:05 AM</div>
        </div> --}}
      </div>

      <div class="chat-input">
        <div class="input-container">
          <input type="text" placeholder="Type your message here..." />
          <button class="send-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="22" y1="2" x2="11" y2="13"></line>
              <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

@push('bottom')
@include('include.comment-box-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const chatContainer = document.querySelector('.chat-container');
      const chatBubble = document.querySelector('.chat-bubble');
      const chatClose = document.querySelector('.chat-close');
      const themeToggle = document.querySelector('.theme-toggle');
      const sunIcon = document.querySelector('.sun-icon');
      const moonIcon = document.querySelector('.moon-icon');
      const sendButton = document.querySelector('.send-button');
      const messageInput = document.querySelector('.input-container input');
      const chatMessages = document.querySelector('.chat-messages');
      const html = document.documentElement;

      // Check for saved theme preference or use default
      const savedTheme = localStorage.getItem('chat-theme');
      if (savedTheme === 'dark') {
        enableDarkMode();
      } else {
        enableLightMode();
      }

      // Function to enable dark mode
      function enableDarkMode() {
        html.classList.add('dark-theme');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
        localStorage.setItem('chat-theme', 'dark');
      }

      // Function to enable light mode
      function enableLightMode() {
        html.classList.remove('dark-theme');
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
        localStorage.setItem('chat-theme', 'light');
      }

      // Function to toggle theme
      function toggleTheme() {
        if (html.classList.contains('dark-theme')) {
          enableLightMode();
        } else {
          enableDarkMode();
        }
      }

      // Function to open chat
      function openChat() {
        chatContainer.classList.add('open');
        // Scroll to bottom of messages
        scrollToBottom();
      }

      // Function to close chat
      function closeChat() {
        chatContainer.classList.remove('open');
      }

      // Function to add a new message
      function addMessage(content, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message');
        messageDiv.classList.add(isUser ? 'user' : 'agent');

        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
        const timeString = `${formattedHours}:${formattedMinutes} ${ampm}`;

        messageDiv.innerHTML = `
          <div class="message-content">
            <p>${content}</p>
          </div>
          <div class="message-time">${timeString}</div>
        `;

        chatMessages.appendChild(messageDiv);
        scrollToBottom();

        // If user sent a message, simulate a response after a delay
        if (isUser) {
          setTimeout(() => {
            simulateResponse();
          }, 1000);
        }
      }

      // Function to simulate a response
      function simulateResponse() {
        const responses = [
          "Thanks for your message! How else can I help?",
          "I understand. Let me check that for you.",
          "Great question! Our team specializes in that area.",
          "I'd be happy to assist with that request.",
          "Let me connect you with the right department for that."
        ];
        
        const randomResponse = responses[Math.floor(Math.random() * responses.length)];
        addMessage(randomResponse, false);
      }

      // Function to scroll chat to bottom
      function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }

      // Event listeners
      chatBubble.addEventListener('click', openChat);
      chatClose.addEventListener('click', closeChat);
      themeToggle.addEventListener('click', toggleTheme);

      // Send message when clicking send button
      sendButton.addEventListener('click', function() {
        sendMessage();
      });

      // Send message when pressing Enter
      messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          sendMessage();
        }
      });

      // Function to send a message
      function sendMessage() {
        const message = messageInput.value.trim();
        if (message) {
          addMessage(message, true);
          messageInput.value = '';
        }
      }

      // Auto-focus input when chat opens
      chatBubble.addEventListener('click', function() {
        setTimeout(() => {
          messageInput.focus();
        }, 300);
      });
    });
</script>
@endpush