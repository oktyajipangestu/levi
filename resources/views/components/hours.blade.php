<div>
    <span class="rounded px-2 py-1" style="background-color: #F3F3FF">
        <small>
            {{ $duration }} @if ($duration == 1)
                Hour
            @elseif(!is_numeric($duration))
            @else
                Hours
            @endif
        </small>
    </span>
</div>
