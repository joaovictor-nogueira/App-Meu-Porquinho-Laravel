<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Meu Porquinho')
<img src="http://localhost:8000/img/logo.png" class="logo" alt="Meu Porquinho Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
