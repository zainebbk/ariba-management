<table
    class="table table-bordered table-bordered mp-0 table-striped table-vcenter border-top"
    id="example1">
    <thead>
        <tr>
            <th class="w-7 h-7 rounded shadow mr-3">Picture</th>
            <th class="wd-15p border-bottom-0">Product Id</th>
            <th class="wd-15p border-bottom-0">Product title</th>
            <th class="wd-15p border-bottom-0">Brand</th>
            <th class="wd-15p border-bottom-0">AR Number</th>
            <th class="wd-15p border-bottom-0">EAN</th>
            <th class="wd-20p border-bottom-0">Price</th>
            <th class="wd-20p border-bottom-0">Quantity</th>
            <th class="wd-20p border-bottom-0">Status</th>
            <th class="border-bottom-0 w-10">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['products'] as $product)
            <tr>
                <td><img class="w-7 h-7 rounded shadow mr-3"  src="https://ariba.ma/image/{{ $product->image }}" ></td>
                <td>{{ $product->product_id }}</td>
                <td><a href="{{route('vendor-update-product',$product->product_id)}}">{{ $product->name }}</a></td>
                <td>{{ $product->manufacturer }}</td>
                <td>{{ $product->model }}</td>
                <td>{{ $product->ean }}</td>
                <td>{{ $product->price-number_format(floatval($product->price*0.2),2) }} DH</td>
                <td><span
                        class="badge badge-primary mt-2">{{ $product->quantity }}</span>
                </td>
                <td>
                    @if ($product->status == 0)<span
                        class="badge badge-danger mt-2">Disabled</span>@else<span
                            class="badge badge-success mt-2">Enabled</span>@endif
                </td>
                
                <td class="align-middle">
                    <div class="btn-group align-top">
                        <button class="btn btn-sm btn-primary" type="button"><a
                                href="{{route('vendor-update-product',$product->product_id)}}"
                                target="_blank" style="color:white">Edit</a></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
