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
            <p>Please Read or Type your comments here.</p>
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

    @if(request()->segment(3) == "detail" && CRUDBooster::getModulePath() != "transaction_history")
      <div class="chat-messages">
        @if(count($data['Comment']) > 0)
            @foreach($data['Comment'] as $comment)
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
        @else
            <div class="row no-comment">
                <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" alt="">
                <h4>No Comments Yet</h4>
                <p>Be the first to comment.</p>
            </div>
        @endif
      </div>
      
    @elseif(request()->segment(3) == "getDetailView" && CRUDBooster::getModulePath() == "transaction_history")
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
            @else
                <div class="row no-comment">
                    <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" alt="">
                    <h4>No Comments Yet</h4>
                    <p>Be the first to comment.</p>
                </div>
            @endif
        </div>
        <div class="chat-input">
            <div class="input-container">
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <input type="hidden" value="{{$transaction_details->header_id}}" name="transaction_comment_id" id="transaction_comment_id">
            <input type="text" name="comment" id="comment" autocomplete="off" required placeholder="Type your comment here..." />
            <button type="submit" onclick="AllComments()" id="clickSubmit" class="send-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
            </div>
        </div>

    @elseif(request()->segment(3) == "edit" || CRUDBooster::getModulePath() == "transaction_history")
        <div class="chat-messages">
            @if(count($data['Comment']) > 0)
                @foreach($data['Comment'] as $comment)
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
            @else
                <div class="row no-comment">
                    <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" alt="">
                    <h4>No Comments Yet</h4>
                    <p>Be the first to comment.</p>
                </div>
            @endif
        </div>
        <div class="chat-input">
            <div class="input-container">
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <input type="hidden" value="{{$transaction_details->header_id}}" name="transaction_comment_id" id="transaction_comment_id">
            <input type="text" name="comment" id="comment" autocomplete="off" required placeholder="Type your comment here..." />
            <button type="submit" onclick="AllComments()" id="clickSubmit" class="send-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
            </div>
        </div>
    @endif
    
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

      // Function to scroll chat to bottom
      function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }

      // Event listeners
      chatBubble.addEventListener('click', openChat);
      chatClose.addEventListener('click', closeChat);
      themeToggle.addEventListener('click', toggleTheme);

      // Auto-focus input when chat opens
      chatBubble.addEventListener('click', function() {
        setTimeout(() => {
          messageInput.focus();
        }, 300);
      });
    });
</script>
@endpush