<table
    class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
    id="example1">
    <thead>
        <tr>
            <th class="w-7 h-7 rounded shadow mr-3">Picture</th>
            <th class="wd-15p border-bottom-0">Product Id</th>
            <th class="wd-15p border-bottom-0">Product title</th>
            <th class="wd-15p border-bottom-0">Store</th>
            <th class="wd-15p border-bottom-0">Model</th>
            <th class="wd-15p border-bottom-0">EAN</th>
            <th class="wd-20p border-bottom-0">Price</th>
            <th class="wd-20p border-bottom-0">Quantity</th>
            <th class="wd-20p border-bottom-0">Status</th>
            <th class="wd-20p border-bottom-0">Added date</th>
            <th class="border-bottom-0 w-10">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['products'] as $product)
            <tr>
                @php  $trimmed = trim($product->image, ".png|.png|.jpeg"); @endphp
                @php
                    $filename = $product->image;
                    $newFileName = substr($filename, 0 , (strrpos($filename, ".")));
                    $pos = strpos($filename, "png");
                    if($pos==True)
                        $extension="png";
                    $extension="jpeg";
                @endphp
                <td><img class="w-7 h-7 rounded shadow mr-3" src="https://ariba.ma/image/{{ $filename }}"></td>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->display_name ?? '' }}</td>
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
                <td>{{ $product->date_added }}</td>
                <td class="align-middle">
                    <div class="btn-group align-top">
                        <button class="btn btn-sm btn-primary" type="button"><a
                                href="product/update/{{ $product->product_id }}"
                                target="_blank" style="color:white">Show</a></button>
                        <!-- <button class="btn btn-sm btn-info" type="button"><a href="product/verify/{{ $product->product_id }}" style="color:white">Verify</a></button>-->
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
