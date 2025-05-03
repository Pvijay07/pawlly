@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
    <style>
        .alternate-list {
            display: flex;
            flex-direction: column;
            margin-bottom: 0;
        }
        .alternate-list li:not(:last-child){
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--bs-border-color);
        }
    </style>

<style type="text/css" media="print">
      @page :footer {
        display: none !important;
      }

      @page :header {
        display: none !important;
      }
      @page { size: landscape; }
      /* @page { margin: 0; } */

      .pr-hide {
        display: none;
        }

        	
    .order_table tr td div{
           white-space: normal;
        }

      button {
        display: none !important;
      }
      * {
        -webkit-print-color-adjust: none !important;   /* Chrome, Safari 6 – 15.3, Edge */
        color-adjust: none !important;                 /* Firefox 48 – 96 */
        print-color-adjust: none !important;           /* Firefox 97+, Safari 15.4+ */
      }
    </style>

    <div class="row pr-hide">
        <div class="col-12">
            <div class="card ">
                <div class="card-header border-bottom-0">
                    <div class="row pr-hide">
                        <div class="col-auto col-lg-4 mb-4">
                            <div class="input-group">
                                <select class="form-select select2" name="payment_status"
                                    data-minimum-results-for-search="Infinity" id="update_payment_status">
                                    <option value="" disabled>
                                    {{__('product.payment_status')}}
                                    </option>

                                     <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                    {{__('product.lbl_paid')}}
                                    </option>
                                    <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                    {{__('product.unpaid')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-auto col-lg-4 mb-4">
                            <div class="input-group">
                                <select name="delivery_status" class="form-control select2" name="delivery_status"
                                    data-ajax--url="{{ route('backend.get_search_data', ['type' => 'constant', 'sub_type' => 'ORDER_STATUS']) }}"
                                    data-ajax--cache="true">
                                    <option value="" disabled>{{__('product.delivery_status')}}</option>
                                    @if (isset($order->delivery_status))
                                        <option value="{{ $order->delivery_status }}" selected>
                                            {{ Str::title(Str::replace('_', ' ', $order->delivery_status)) }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-auto col-lg-4 mb-4 text-center text-lg-end">
                            <a class="btn btn-primary" onclick="invoicePrint(this)">
                                <i class="fa-solid fa-download"></i>
                                {{__('product.download_invoice')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!--Main Invoice-->
        <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
            <div class="card mb-4" id="section-1">
                <div class="card-body">
                    <!--Order Detail-->
                    <div class="row justify-content-between align-items-center g-3 mb-4">
                        <div class="col-auto flex-grow-1">
                            {{-- <img src="{{ asset(setting('logo')) }}" alt="logo" class="img-fluid" width="200"> --}}
                            <div class="welcome-message">
                                <h5 class="mb-2">Customer Info</h6>
                                    <p class="mb-0">Name: <strong>{{ optional($order->user)->full_name }}</strong></p>
                                    <p class="mb-0">Email: <strong>{{ optional($order->user)->email }}</strong></p>
                                    <p class="mb-0">Phone: <strong>{{ optional($order->user)->mobile }}</strong></p>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h5 class="mb-0">{{__('product.invoice')}}
                                <span
                                    class="text-accent">{{ setting('inv_prefix') }}{{ $order->orderGroup->order_code }}
                                </span>
                            </h5>
                            <span class="text-muted">{{__('product.order_date')}}:
                                {{ date('d M, Y', strtotime($order->created_at)) }}
                            </span>
                            @if ($order->location_id != null)
                                <div>
                                    <span class="text-muted">
                                        <i class="las la-map-marker"></i> {{ optional($order->location)->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-md-between justify-content-center g-3">
                        <div class="col-auto">
                            <!--Customer Detail-->
                            {{-- <div class="welcome-message">
                                <h5 class="mb-2">Customer Info</h6>
                                    <p class="mb-0">Name: <strong>{{ optional($order->user)->full_name }}</strong></p>
                                    <p class="mb-0">Email: <strong>{{ optional($order->user)->email }}</strong></p>
                                    <p class="mb-0">Phone: <strong>{{ optional($order->user)->mobile }}</strong></p>
                            </div> --}}
                            <div class="col-auto mt-3">
                                <h6 class="d-inline-block">{{__('product.payment_method')}} </h6>
                                <span class="badge bg-primary">{{ ucwords(str_replace('_', ' ', $order->orderGroup->payment_method)) }}</span>
                            </div>
                            <h6 class="col-auto d-inline-block">{{__('product.logistic')}} </h6> <span class="badge bg-primary">{{ $order->logistic_name }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="shipping-address d-flex justify-content-md-end gap-3 mb-3">
                                <div class="border-end w-25">
                                    <h5 class="mb-2">{{__('product.shipping_address')}}</h5>
                                        @php
                                            $shippingAddress = $order->orderGroup->shippingAddress;
                                        @endphp
                                        <p class="mb-0 text-wrap">
                                            {{ optional($shippingAddress)->address_line_1 }},
                                            {{ optional($shippingAddress->city_data)->name }},
                                            {{ optional($shippingAddress->state_data)->name }},
                                            {{ optional($shippingAddress->country_data)->name }}
                                        </p>
                                </div>
                                @if (!$order->orderGroup->is_pos_order)
                                    <div class="w-25">
                                        <h5 class="mb-2">{{__('product.billing_address')}}</h5>
                                        @php
                                            $billingAddress = $order->orderGroup->billingAddress;
                                        @endphp
                                        <p class="mb-0 text-wrap">

                                            {{ optional($billingAddress)->address_line_1 }},
                                            {{ optional($billingAddress->city_data)->name }},
                                            {{ optional($billingAddress->state_data)->name }},
                                            {{ optional($billingAddress->country_data)->name }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <!-- <div class="shipping-address d-flex justify-content-md-end gap-3">
                                <div class="w-25"></div>
                                <div class="w-25">

                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!--order details-->
                <table class="table table-bordered border-top order_table" data-use-parent-width="true">
                    <thead>
                        <tr>
                            <th class="text-center" width="7%">{{__('product.s_l')}}</th>
                            <th>{{__('product.title')}}</th>
                            <th>{{__('product.unit_price')}}</th>
                            <th>{{__('product.qty')}}</th>
                            <th class="text-end">{{__('product.total_price')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->orderItems as $key => $item)
                            @php
                                $product = $item->product_variation->product;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                    <div>
                                        <img src="{{ optional($product)->feature_image ?? default_user_avatar() }}" alt="{{ optional($product)->name }}"
                                            class="avatar avatar-50 rounded-pill">
                                    </div>

                                        <div class="ms-2">
                                            <h6 class="fs-sm mb-0">
                                                {{ optional($product)->name ? optional($product)->name : '--' }}
                                            </h6>
                                            <div class="text-muted">
                                                @foreach (generateVariationOptions($item->product_variation->combinations) as $variation)
                                                    <span class="fs-xs">
                                                        {{ $variation['name'] }}:
                                                        @foreach ($variation['values'] as $value)
                                                            {{ $value['name'] }}
                                                        @endforeach
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="">
                                    <span class="fw-bold">{{ \Currency::format($item->unit_price) }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ $item->qty }}</td>

                                <td class=" text-end">
                                    @if ($item->refundRequest && $item->refundRequest->refund_status == 'refunded')
                                        <span
                                            class="badge bg-soft-info rounded-pill text-capitalize">{{ $item->refundRequest->refund_status }}</span>
                                    @endif
                                    <span class="text-accent fw-bold">{{ \Currency::format($item->total_price) }}
                                    </span>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="text-end">
                        <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">{{__('product.sub_total')}} </h6>
                            </td>
                            <td width="10%">
                                <strong>{{ \Currency::format($order->orderGroup->sub_total_amount) }}</strong></td>
                        </tr>
                         <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">Tax : </h6>
                            </td>
                            <td width="10%" class="text-end">
                                <strong>{{ \Currency::format($order->orderGroup->total_tax_amount) }}</strong></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">{{__('product.shipping_cost')}} </h6>
                            </td>
                            <td width="10%" class="text-end">
                                <strong>{{ \Currency::format($order->orderGroup->total_shipping_cost) }}</strong></td>
                        </tr>
                        @if ($order->orderGroup->total_coupon_discount_amount > 0)
                            <tr>
                                <td colspan="4">
                                    <h6 class="d-inline-block me-3">{{__('product.coupon_discount')}} </h6>
                                </td>
                                <td width="10%" class="text-end">
                                    <strong>{{ \Currency::format($order->orderGroup->total_coupon_discount_amount) }}</strong>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">{{__('product.grand_total')}} </h6>
                            </td>
                            <td width="10%" class="text-end"><strong
                                    class="text-accent">{{ \Currency::format($order->orderGroup->grand_total_amount) }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!--Note-->
                <div class="card-body">
                    <div class="card-footer border-top-0 px-4 py-4 rounded bg-soft-gray border border-2">
                        <p class="mb-0">{{ setting('spacial_note') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!--Order Status-->
        <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2 pr-hide">
            <div class="sticky-sidebar">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">{{__('product.order_status')}}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="alternate-list list-unstyled">

                            @forelse ($order->orderUpdates as $orderUpdate)
                                <li>
                                    <a class="{{ $loop->first ? 'active' : '' }}">
                                        {{ $orderUpdate->note }} <br> {{__('product.by')}}
                                        <span class="text-capitalize">{{ optional($orderUpdate->user)->name }}</span>
                                        at
                                        {{ date('d M, Y', strtotime($orderUpdate->created_at)) }}.</a>
                                </li>
                            @empty
                                <li>
                                    <a class="active">{{__('product.no_logs_found')}}</a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        function invoicePrint() {
            window.print()
        }

        function updateStatusAjax(__this, url) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    order_id: {{ $order->id }},
                    status: __this.val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status) {
                        window.successSnackbar(res.message)
                        setTimeout(() => {
                            location.reload()
                        }, 100);
                    }
                }
            });
        }
        $('[name="payment_status"]').on('change', function() {
            if ($(this).val() !== '') {
                updateStatusAjax($(this), "{{ route('backend.orders.update_payment_status') }}")
            }
        })

        $('[name="delivery_status"]').on('change', function() {
            if ($(this).val() !== '') {
                updateStatusAjax($(this), "{{ route('backend.orders.update_delivery_status') }}")
            }
        })
    </script>
@endpush
