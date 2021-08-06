@foreach ($best_sales as $product)
    <tr>
        <td class="font-weight-bold"><img class="w-7 h-7 rounded shadow mr-3" src="https://www.ariba.ma/image/{{$product->image}}" alt="{{$product->image}}"><a href="product/update/{{$product->product_id}}"> {{$product->name}}</a></td>
        <td><span class="badge badge-primary">{{$product->sum_quantity}}</span></td>
        <td>{{$product->quantity}}</td>
        <td class="number-font">{{$product->sum_total}} DH</td>
        <td>@if($product->quantity>0)<i class="fa fa-check mr-1 text-success"></i> In Stock @else <i class="fa fa-check mr-1 text-danger"></i> Out of stock @endif</td>
    </tr>
@endforeach