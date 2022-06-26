@extends('admin.layout')
@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">


        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">Coupon</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item ">
                                        <a href="https://www.pixinvent.com/demo/frest-bootstrap-laravel-admin-dashboard-template/demo-1/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item ">
                                        <a href="/">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                         Coupon           </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>        			</div>
            <div class="content-body">

<section class="invoice-view-wrapper">
  <div class="row">
    <!-- invoice view page -->
    <div class="col-xl-12 col-md-12 col-12">
      <div class="card invoice-print-area">
        <div class="card-content">
          <div class="card-body pb-0 mx-25">
            <!-- header section -->
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <span class="invoice-number mr-50">Invoice#</span>
                <span>{{$item->id}}</span>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                  <div class="mr-3">
                    <small class="text-muted">Order Date:</small>
                    <span>{{$item->created_at}}</span>
                  </div>
                  {{--<div>--}}
                    {{--<small class="text-muted">Date Due:</small>--}}
                    {{--<span>08/10/2019</span>--}}
                  {{--</div>--}}
                </div>
              </div>
            </div>
            <!-- logo and title -->
            <div class="row my-3">
              <div class="col-6">
                <h4 class="text-primary">Past Control M. Walshe</h4>
                {{--<span>Software Development</span>--}}
              </div>
              <div class="col-6 d-flex justify-content-end">
                <img src="{{asset('logo.svg')}}" alt="logo" height="46" width="164">
              </div>
            </div>
            <hr>
            <!-- invoice address and contact -->
            <div class="row invoice-info">
              <div class="col-6 mt-1">
                <h6 class="invoice-from">Bill From</h6>
                <div class="mb-1">
                  <span>Past Control M. Walshe</span>
                </div>
                <div class="mb-1">
                  <span>503, Embassy Centre, Nariman Point, Mumbai - 400 021</span>
                </div>
                <div class="mb-1">
                  <span>info@pcmw.com</span>
                </div>
                <div class="mb-1">
                  <span>91-22-22040634</span>
                </div>
              </div>

              @php
               $address = DB::table('address')->where('id',$item->address)->first();
              @endphp
              <div class="col-6 mt-1">
                <h6 class="invoice-to">Bill To</h6>
                <div class="mb-1">
                  <span>{{$address->fname.' '.$address->lname}} </span>
                </div>
                <div class="mb-1">
                  <span>{{$address->address}} <br>{{$address->city.', '.$address->state.'-'.$address->zip}}</span>
                </div>
                <div class="mb-1">
                  <span>{{$address->email}}</span>
                </div>
                <div class="mb-1">
                  <span>{{$address->contact}}</span>
                </div>
              </div>
            </div>
            <hr>
          </div>

          <!-- product details table-->
          <div class="invoice-product-details table-responsive mx-md-25">
            <table class="table table-borderless mb-0">
              <thead>
                <tr class="border-0">
                  <th scope="col">Package</th>

                  <th scope="col">Price</th>
{{--                  <th scope="col">Discount</th>--}}
                  <th scope="col" class="text-right">Status</th>
                </tr>
              </thead>
              <tbody>
              @php($data = $item->package->toArray())
{{--              @foreach( as $key=>$data)--}}
{{--@dd($item->order[0]['orderStatus'])--}}
                <tr>
                  <td>{{$data['service']['title'].' in '.$data['area']['area'].' '.$data['propertype']['propertyType'].' @ '.$data['location']['location']}}</td>

                  <td>{{$data['price']}}</td>
{{--                  <td>@if($data->package['price'] != null){{$data->package['price']}}@endif</td>--}}

                  <td class="text-primary text-right font-weight-bold"><a href="/admin/user/block/{{$item->order[0]['id']}}/orderstatus">{{$item->order[0]['orderStatus']}}</a> </td>
                </tr>
{{--                @endforeach--}}

              </tbody>
            </table>
          </div>

          <!-- invoice subtotal -->
          <div class="card-body pt-0 mx-25">
            <hr>
            <div class="row">
              <div class="col-4 col-sm-6 mt-75">
                <p>Thanks for your business.</p>
              </div>
              <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                <div class="invoice-subtotal">
                  <div class="invoice-calc d-flex justify-content-between">
                    <span class="invoice-title">Subtotal</span>
                    <span class="invoice-value" id="Subtotal">{{$item->payment}}</span>
                  </div>

{{--                   <div class="invoice-calc d-flex justify-content-between">--}}
{{--                    <span class="invoice-title">Offer</span>--}}
{{--                    @isset($item['offers'])--}}

{{--                    <span class="invoice-value">--}}
{{--                        @if($item['offers']['discount_type'] == 'percent')--}}
{{--                          {{$item['offers']['amount'].'%'}}--}}

{{--                        @else--}}
{{--                           {{'INR'.$item['offers']['amount']}}--}}
{{--                        @endif</span>--}}
{{--                        @endisset--}}
{{--                  </div>--}}
                  <div class="invoice-calc d-flex justify-content-between">
                    <span class="invoice-title">Total</span>
                    <span class="invoice-value" id="total">{{$item->payment}}</span>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- invoice action  -->
{{--    <div class="col-xl-3 col-md-4 col-12">--}}
{{--      <div class="card invoice-action-wrapper shadow-none border">--}}
{{--        <div class="card-body">--}}

{{--          <div class="invoice-action-btn">--}}
{{--            <button class="btn btn-light-primary btn-block invoice-print1" onclick="printDiv('invoice-print-area')">--}}
{{--              <span>print</span>--}}
{{--            </button>--}}
{{--          </div>--}}
{{--          <div class="invoice-action-btn">--}}
{{--            <a href="app-invoice-edit.html" class="btn btn-light-primary btn-block">--}}
{{--              <span>Edit Invoice</span>--}}
{{--            </a>--}}
{{--          </div>--}}

{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
  </div>
</section>


            </div>
        </div>
    </div>

    <script>

        function printDiv(divName) {
            var printContents = document.getElementsByClassName('invoice-print-area').innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
        function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

    </script>
@endsection


