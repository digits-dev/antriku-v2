<table class="transactions-table">
    <thead>
      <tr>
          <th>Reference No.</th>
          <th>Customer Name</th>
          <th>First Call-out Date</th>
          <th>Release Date</th>
          <th>Duration</th>
          <th>Status</th>
          {{-- <th>-</th> --}}
      </tr>
    </thead>
    <tbody id="transactions-body">
      @foreach ($time_motion as $per_transaction)    
        <tr>
          <td>{{$per_transaction->reference_no}}</td>
          <td>{{$per_transaction->last_name .','. $per_transaction->first_name}}</td>
          <td>{!! $per_transaction->first_timestamp ?? '<span style="color: #ef4444">No call out logs</span>' !!}</td>
          <td>{!! $per_transaction->completed_at ?? '<span style="color: #ef4444">No release date logs</span>' !!}</td>
          <td>
              @if (empty($per_transaction->first_timestamp) || empty($per_transaction->completed_at))
                  <svg xmlns="http://www.w3.org/2000/svg" style="color: #2563eb" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="time-icon"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  <span style="color: #2563eb">Pending</span>
              @else
                  @php 
                      if ($per_transaction->first_timestamp && $per_transaction->completed_at) {
                          $start = \Carbon\Carbon::parse($per_transaction->first_timestamp);
                          $end = \Carbon\Carbon::parse($per_transaction->completed_at);
                  
                          $duration = $start->diff($end);
                          $parts = [];
                  
                          if ($duration->d > 0) {
                              $parts[] = $duration->d . " day/s";
                          }
                          if ($duration->h > 0) {
                              $parts[] = $duration->h . " hr/s";
                          }
                          if ($duration->i > 0) {
                              $parts[] = $duration->i . " min/s";
                          }
                          if ($duration->s > 0 || empty($parts)) { 
                              $parts[] = $duration->s . " sec/s";
                          }
                  
                          $formattedDuration = implode(", ", $parts);
                      } else {
                          $formattedDuration = '<span class="text-danger">Incomplete data</span>';
                      }
                  @endphp
                  <svg xmlns="http://www.w3.org/2000/svg" style="color: #06d6a0" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="time-icon"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  {!! '<span style="color: #06d6a0">'.$formattedDuration.'</span>' !!}
              @endif
          </td>
          <td>
              <span class="status-badge {{$per_transaction->repair_status == 6 ? 'status-completed' : 'status-processing'}}">
                @if ($per_transaction->repair_status == 6)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" style="color: #2563eb" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="time-icon"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                @endif
                {{$per_transaction->status_name}}
              </span>
          </td>
          {{-- <td class="text-primary" style="cursor: pointer"><u>View details</u></td> --}}
        </tr>
      @endforeach
    </tbody>
</table>
