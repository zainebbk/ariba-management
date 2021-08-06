@extends('admin.layouts.master-print')
@section('css')
    <style type="text/css" media="print">
        .noprint {
            display: none;
        }

        .table-bordered,
        .text-wrap table,
        .table-bordered th,
        .text-wrap table th,
        .table-bordered td,
        .text-wrap table td {
            border: 0.1px solid #ababab !important;
            font-size: 13px;

        }

        .table-bordered th {
            color: #1a1630 !important;
        }

        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            font-size: 24px;
            display: block;
            z-index: 1;
        }

        table {
            page-break-before: auto;
        }

        @page {
            size: A4;
            margin: 30px 6mm 0px;
            padding: 100px 0
        }

        @media print {
            table {
                page-break-after: auto
            }

            tr {
                page-break-after: auto;
                page-break-inside: auto;
            }

            footer {
                position: fixed;
                bottom: 0;
                display: block;
                z-index: 1;
            }
        }

    </style>
@endsection
@section('content')
    <div class="row" style="margin: 15px 30px 10px 10px; padding-bottom: 100px">
        <div style="page-break-after: always;">
            <div class="row" style="margin: 0px 0px;">
                <div class="col-5 col-lg-5 col-md-5" style="padding-left: 0;text-align: center;margin-top:32px;">
                    <img src="https://infodat.com/mgmt/assets/images/brand/logo.png" alt="ariba_logo" style="width: 48%">
                </div>
                @php $total=0;@endphp
                @foreach ($order_products as $order_product)
                    @foreach ($order_options as $order_option)
                        @if ($order_product->order_product_id == $order_option->order_product_id)
                            @php $total+=($order_product->total+$order_product->tax*$order_product->quantity); @endphp
                        @endif
                    @endforeach
                @endforeach
                <div class="col-6 col-lg-6 col-md-6"
                    style="margin-bottom:0px;padding:40px 0;border: 2px solid #000; text-align: center;">
                    <h5 style="color: #555;font-weight: 600;margin: 30px 0px;font-size: 26px;display: block;">
                        PRIX TOTAL : {{ number_format(floatval($total), 2) }}MAD</h5>
                </div>
            </div>

            <hr style="background: #ddd; padding: 1px 0px;border-top: 1px solid #555555;">

            <div class="row" style="margin: 0 0 30px">
                <div class="col-md-6" style="text-align: left;">
                    @if ($invoice)
                        <h5 style="color: #555;font-weight: 600;font-size: 36px;display: block;">FACTURE
                            #{{ str_pad($invoice->invoice_no, 4, '0', STR_PAD_LEFT) }}</h5>
                    @else
                        <h5 style="color: #555;font-weight: 600;font-size: 36px;display: block;"> N ° de commande
                            #{{ $order->invoice_id }}</h5>
                    @endif
                </div>
                <div class="col-md-6" style="text-align: right">
                    <h6 style="font-size: 16px;">
                </div>
            </div>
            <div class="row" style="margin: 0 0 10px">
                <div class="col-md-12">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="1" style="width: 50%;"><b>Vendeur Information</th></b>
                                <th colspan="1" style="width: 50%"><b>Commande Details</th></b>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <address>
                                        <b>{{ $vendor->display_name }}</b><br>
                                        {{ $vendor->address_1 }}
                                        {{ $vendor->address_2 }}

                                        <br />{{ $vendor->city }} {{ $vendor->postcode }}, Morocco<br />
                                        {{ $vendor->telephone }}<br />
                                        {{ $vendor->email }}
                                    </address>
                                </td>
                                <td>
                                    <address>
                                        <h6 style="font-size: 14px;">Date de commande :
                                            {{ date('d-m-Y', strtotime($order->date_added)) }}</h6>

                                        <h6 style="font-size: 14px;">N ° de commande :
                                            # {{ $order->invoice_id }}</h6>

                                        <h6 style="font-size: 14px;">Mode de paiement :
                                            @if ($order->payment_code == 'cod') Paiement à
                                            la livraison @else {{ $order->payment_method }} @endif
                                        </h6>
                                        <!--<h6 style="font-size: 14px;">Mode de livraison :
                                                    {{ $order->shipping_method }}
                                                </h6>-->
                                    </address>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="row" style="margin: 0 0 30px">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="1" style="width: 50%"><b>Client : Adresse de facturation</b></th>
                                <th colspan="1" style="width: 50%"><b>Client : Adresse de livraison</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <address>
                                        {{ $order->payment_firstname }}<br />
                                        {{ $order->payment_address_1 }}<br />
                                        {{ $order->payment_zone }}<br />
                                        {{ $order->payment_country }}
                                    </address>
                                </td>
                                <td>
                                    <address>
                                        {{ $order->payment_firstname }} {{ $order->payment_lastname }}<br />
                                        {{ $order->payment_address_1 }}<br />
                                        {{ $order->payment_zone }}<br />
                                        {{ $order->payment_country }}
                                    </address>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive push mt-3 mr-4 ml-4" style="page-break-after: always;">
                    <table class="table table-bordered table-hover">
                        <tr class=" ">
                            <th><b>Produit</b></th>
                            <th class="text-center" style="width: 1%"><b>
                                    Taille</b></th>
                            <th class="text-center" style="width: 1%"><b>
                                    Modèle</b></th>
                            <th class="text-center" style=""><b>Quantity</b></th>
                            <th class="text-right" style="width: 1%"><b>Prix ​​unitaire</b></th>
                            <th class="text-right" style="width: 1%"><b>TVA</b></th>
                            <th class="text-right" style="width: 1%"><b>Montant</b></th>
                        </tr>

                        @php $total=0;@endphp
                        @foreach ($order_products as $order_product)
                            @foreach ($order_options as $order_option)
                                @if ($order_product->order_product_id == $order_option->order_product_id)
                                    @php $total+=($order_product->total+$order_product->tax*$order_product->quantity); @endphp
                                    <tr>
                                        <td>
                                            <p class="font-weight-semibold mb-1">{{ $order_product->name }}</p>

                                            <div class="text-muted"></div>
                                        </td>
                                        <td class="text-center">{{ $order_option->value }}</td>
                                        <td class="text-center">{{ $order_product->model }}</td>
                                        <td class="text-center">{{ $order_product->quantity }}</td>
                                        <td class="text-right">
                                            {{ number_format(floatval($order_product->price), 2) }}</td>
                                        <td class="text-center"> {{ number_format(floatval($order_product->tax), 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format(floatval($order_product->total + $order_product->tax * $order_product->quantity), 2) }}MAD
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach

                        <tr>
                            <td colspan="6" class="font-weight-bold text-uppercase text-right h4 mb-0">Grand Total
                            </td>
                            <td class="font-weight-bold text-right h4 mb-0">
                                {{ number_format(floatval($total) ?? 0, 2) ?? 0 }}MAD
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12" style="margin: 30px 0">
                    <button type="button" class="btn btn-primary btn-lg btn-block noprint" onclick="window.print()">Print
                        this page</button>
                </div>
            </div>
        </div>
    </div>
@endsection
</body>

</html>
