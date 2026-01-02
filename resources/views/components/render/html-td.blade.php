<td class="align-middle">
@if(is_array($value))

    @foreach($value as $v)
        <span class="me-2">{{ $v }}</span>
    @endforeach

@else
    {{ $value }}
@endif
</td>
