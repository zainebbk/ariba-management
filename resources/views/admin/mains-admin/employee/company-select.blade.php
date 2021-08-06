@foreach ($companies as $company)
    <tr>
        <td>{{ $company->name }}</td>
        <td>{{ $company->e_firstname }} {{ $company->e_lastname }}</td>
        <td>{{ $company->address1 }} {{ $company->city }}</td>
        <td>{{ $company->phone }}</td>
        <td>{{ $company->owner }}</td>
        <td>{{ $company->ownerEmail }}</td>
        <td>{{ $company->ownerPhone }}</td>
        <td><span class="badge @if ($company->note == 'null') badge-danger
        @elseif($company->note=="good") badge-success @else
            badge-warning @endif
            mt-2">{{ $company->note }}</span></td>
    <td>{{ $company->date_added }}</td>
    <td class="align-middle">
        <div class="btn-group align-top">
            <button class="btn btn-sm btn-info approve-btn" type="button"><a href="company/{{ $company->id }}"
                    class="approve" style="color:white">Show</a></button>
        </div>
    </td>
</tr>
@endforeach
