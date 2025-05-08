<div class="pagination-cust" id="pagination_time_motion" style="margin: 0">
    @if ($time_motion->onFirstPage())
        <button class="pagination-btn-cust" disabled>
    @else
        <button class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->previousPageUrl() }}">
    @endif
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>    
    </button>

    @php
        $totalPages = $time_motion->lastPage();
        $currentPage = $time_motion->currentPage();
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $startPage + 4);
        $startPage = max(1, $endPage - 4);
    @endphp

    @if ($startPage > 1)
        <button class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->url(1) }}">1</button>
        @if ($startPage > 2)
            <span>...</span>
        @endif
    @endif

    @for ($i = $startPage; $i <= $endPage; $i++)
        <button class="pagination-btn-cust pagination-link {{ $i == $currentPage ? 'active' : '' }}" 
            data-url="{{ $time_motion->url($i) }}">
            {{ $i }}
        </button>
    @endfor

    @if ($endPage < $totalPages)
        @if ($endPage < $totalPages - 1)
            <span>...</span>
        @endif
        <button class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->url($totalPages) }}">{{ $totalPages }}</button>
    @endif

    @if ($time_motion->currentPage() == $time_motion->lastPage())
        <button class="pagination-btn-cust" disabled>
    @else
        <button class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->nextPageUrl() }}">
    @endif
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>  
    </button>
</div>

<script>
  $(document).ready(function() {
      $('.pagination-link').on('click', function(e) {
          e.preventDefault();
          
          let url = $(this).data('url');
          if (!url) return;

          $.ajax({
              url: url,
              type: 'GET',
              beforeSend: function() {
                $('#time_motion_data').html(`
                    <div style="display: flex; justify-content: center">
                      <img width="100" src="https://cdn-icons-gif.flaticon.com/10282/10282620.gif"/>
                    </div>
                    <center><p style="text-align:center">Loading data, please wait...</p></center>`);
              },
              success: function(data) {
                  $('#time_motion_data').html($(data.table));
                  $('#pagination_time_motion').html($(data.pagination));
              },
              error: function() {
                  alert('Error loading data.');
              }
          });
      });
  });
</script>