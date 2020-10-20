<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'EPEN')
<img src="{{asset('images/logoepen.png')}}" class="logo" alt="EPEN logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
