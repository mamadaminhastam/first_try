@foreach($transactions as $tx)
<tr>
    <td><span class="badge bg-secondary">{{ $tx->tokenFrom->symbol }}</span></td>
    <td><span class="badge bg-success">{{ $tx->tokenTo->symbol }}</span></td>
    <td>{{ $tx->amount_from }}</td>
    <td>{{ $tx->amount_to }}</td>
    <td>{{ $tx->rate }}</td>
    <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
</tr>
@endforeach