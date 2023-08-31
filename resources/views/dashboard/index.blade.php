@extends('layouts.app') 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<div class="container">
    <h1>Stream Events Dashboard</h1>
    
     <!-- Display event & revenue summary information -->
     <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Followers</h5>
                    <p class="card-text">{{ $totalFollowersGained }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top 3 Items Sales-wise</h5>
                    <ul class="list-group">
                        @foreach ($topMerchSales as $item)
                            <li class="list-group-item">
                                {{ $item->item_name }} - Quantity: {{ $item->quantity }} - Price: ${{ number_format($item->price, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Display aggregated data -->
    <div class="row mt-4">
        <div class="col-md-12">
            <ul class="list-group">
                @foreach ($aggregatedData as $event)
                        <li class="list-group-item">
                            <li class="list-group-item">
                                @if ($event->type === 'follow')
                                    {{ $event->name }} followed you!
                                @elseif ($event->type === 'subscribe')
                                    {{ $event->follower_name }} (Tier{{ $event->subscription_tier }}) subscribed to you!
                                @elseif ($event->type === 'donate')
                                    {{ $event->follower_name }} donated {{ $event->amount }} {{ $event->currency }} to you!
                                    <br>{{ $event->donation_message }}
                                @elseif ($event->type === 'merch')
                                    {{ $event->follower_name }} bought {{ $event->quantity }} {{ Str::plural($event->item_name) }} from you for {{ $event->price }} USD!
                                @endif
                                <br>
                                @if (!$event->is_read)
            <label>
                <input type="checkbox" class="read-checkbox" data-event-id="{{ $event->id }}" data-event-type="{{ $event->type }}"> Mark as Read
            </label>
        @else
            Read
        @endif
    </li>
@endforeach

<!-- JavaScript for marking as read -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readCheckboxes = document.querySelectorAll('.read-checkbox');

        readCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                const eventId = this.dataset.eventId;
                const eventType = this.dataset.eventType;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send a POST request to mark the event as read
                axios.post('{{ route("dashboard.markAsRead") }}', { event_id: eventId, event_type: eventType }, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(function(response) {
                    if (response.data.success) {
                        console.log(response.data);
                    } else {
                        console.error(response);
                    }
                })
                .catch(function(error) {
                    console.error('Error marking event as read:', error);
                });
            });
        });
    });
</script>


@endsection
