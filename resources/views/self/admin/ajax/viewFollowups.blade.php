@forelse($followups as $followup)
    <div class="border p-2 mb-3">
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($followup->created_at)->format('d-m-Y H:i') }}</p>
        <p><strong>Contacted:</strong>
            {{ $followup->contacted == 0 ? 'No' : 'Yes' }}</p>
        <p><strong>Action Taken:</strong> {{ $followup->action_taken }}</p>
        @if ($followup->follow_up_image)
            <p><strong>Attachment:</strong></p>
            <img src="{{ asset('storage/' . $followup->follow_up_image) }}" alt="Attachment"
                style="max-width: 100%; border: 1px solid #ccc;">
        @endif
    </div>
@empty
    <p>No Follow Up entries found.</p>
@endforelse
