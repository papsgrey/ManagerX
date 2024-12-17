<div class="log-entry">
    <div class="log-timestamp">{{ $entry['timestamp'] }}</div>
    <div class="log-level">{{ strtoupper($entry['level']) }}</div>
    <div class="log-message">{{ $entry['message'] }}</div>
</div>