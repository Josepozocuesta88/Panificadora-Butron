<!-- ======================================================================================= -->
<!-- CLIENTE o TODOS: Carrito de compra -->
<!-- NO SE ESTA USANDO ACTUALMENTE -->
<!-- ======================================================================================= -->

@extends('layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Checkout</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                @if (session('success') || session('error'))
                <div aria-live="polite" aria-atomic="true"
                    style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
                    <div class="toast show bg-primary" data-bs-delay="5000">
                        <div class="toast-header">
                            <strong class="mr-auto text-primary">Alerta</strong>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="toast-body text-white">
                            {{ session('success') ?? session('error') }}
                        </div>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">

                        <!-- Checkout Steps -->
                        <!-- <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#billing-information" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    <i class="mdi mdi-account-circle font-18"></i>
                                    <span class="d-none d-lg-block">Información de Facturación</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#payment-information" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-cash-multiple font-18"></i>
                                    <span class="d-none d-lg-block">Información de pago</span>
                                </a>
                            </li>
                        </ul> -->

                        <!-- Steps Information -->
                        <div class="tab-content">

                            <!-- Billing Content-->
                            <div class="tab-pane show active" id="billing-information">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2">Información de facturación</h4>

                                        <p class="text-muted mb-4">Rellene el siguiente formulario para enviarle la
                                            factura del pedido.</p>

                                        <form action="{{route('makeOrder')}}" method="POST">
                                            @csrf

                                            <input type="hidden" name="items" value="{{ json_encode($items) }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nombre"
                                                            class="form-label">Nombre</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your first name"
                                                            id="nombre" name="nombre"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="apellidos"
                                                            class="form-label">Apellidos</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your last name" id="apellidos" name="apellidos"/>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="email"
                                                            placeholder="Enter your email" id="email"  name="email"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="tlf" class="form-label">Teléfono <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" placeholder=""
                                                            id="tlf" name="tlf"/>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="direccion" class="form-label">Direción de
                                                            envío</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter full address" id="direccion" name="direccion">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="cuidad" class="form-label">Cuidad</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your city name" id="cuidad" name="ciudad"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="provincia" class="form-label">Provincia</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your state" id="provincia" name="provincia"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="codigo_postal" class="form-label">Código
                                                            Postal</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your zip code" id="codigo_postal" name="codigo_postal" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->

                                            <div class="row mt-4">

                                                <div class="col-sm-6">
                                                    <a onclick="window.location.href='/articles/search?query=';"
                                                        class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                        <i class="mdi mdi-arrow-left"></i> Continuar comprando </a>
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <!-- <a href="" class="btn btn-danger">
                                                            <i class="mdi mdi-truck-fast me-1"></i> Procesar el pedido
                                                        </a> -->
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="mdi mdi-truck-fast me-1"></i> Terminar
                                                            pedido</button>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </form>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="border p-3 mt-4 mt-lg-0 rounded">
                                            <h4 class="header-title mb-3">Order Summary</h4>

                                            @if (isset($message))
                                            <div class="alert alert-dark" role="alert">
                                                {{ $message }}
                                            </div>
                                            @else
                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-centered mb-0">
                                                    <tbody>
                                                        @foreach ($items as $item)
                                                        <tr>
                                                            <td>
                                                                <p class="m-0 d-inline-block align-middle">
                                                                    <a href="{{route('info', ['artcod' => $item['artcod']])}}"
                                                                        class="text-body fw-semibold">{{ $item['name'] }}</a>
                                                                    <br>
                                                                    <small>{{ $item['quantity'] }} x
                                                                        {{ $item['price'] }}</small>
                                                                </p>
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $item['total'] }} €
                                                            </td>
                                                        </tr>

                                                        @endforeach
                                                        <tr class="text-end">
                                                            <td>
                                                                <h6 class="m-0">Sub Total:</h6>
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($subtotal, 2) }} €
                                                            </td>
                                                        </tr>
                                                        <tr class="text-end">
                                                            <td>
                                                                <h6 class="m-0">Gastos de envío:</h6>
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($shippingCost, 2) }} €
                                                            </td>
                                                        </tr>
                                                        <tr class="text-end">
                                                            <td>
                                                                <h5 class="m-0">Total:</h5>
                                                            </td>
                                                            <td class="text-end fw-semibold">
                                                                {{ number_format($total, 2) }} €
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif

                                            <!-- end table-responsive -->
                                        </div> <!-- end .border-->

                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                            </div>
                            <!-- End Billing Information Content-->


                            <!-- Payment Content-->
                            <!-- <div class="tab-pane" id="payment-information">
                                <div class="row">

                                    <div class="col-lg-8">
                                        <h4 class="mt-2">Payment Selection</h4>

                                        <p class="text-muted mb-4">Fill the form below in order to
                                            send you the order's invoice.</p>

                                        <div class="border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-check">
                                                        <input type="radio" id="BillingOptRadio2" name="billingOptions"
                                                            class="form-check-input">
                                                        <label class="form-check-label font-16 fw-bold"
                                                            for="BillingOptRadio2">Pay with Paypal</label>
                                                    </div>
                                                    <p class="mb-0 ps-3 pt-1">You will be redirected to PayPal
                                                        website to complete your purchase securely.</p>
                                                </div>
                                                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                    <img src="assets/images/payments/paypal.png" height="25"
                                                        alt="paypal-img">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-check">
                                                        <input type="radio" id="BillingOptRadio1" name="billingOptions"
                                                            class="form-check-input" checked>
                                                        <label class="form-check-label font-16 fw-bold"
                                                            for="BillingOptRadio1">Credit / Debit Card</label>
                                                    </div>
                                                    <p class="mb-0 ps-3 pt-1">Safe money transfer using your bank
                                                        account. We support Mastercard, Visa, Discover and Stripe.
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                    <img src="assets/images/payments/master.png" height="24"
                                                        alt="master-card-img">
                                                    <img src="assets/images/payments/discover.png" height="24"
                                                        alt="discover-card-img">
                                                    <img src="assets/images/payments/visa.png" height="24"
                                                        alt="visa-card-img">
                                                    <img src="assets/images/payments/stripe.png" height="24"
                                                        alt="stripe-card-img">
                                                </div>
                                            </div> 
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="card-number" class="form-label">Card
                                                            Number</label>
                                                        <input type="text" id="card-number" class="form-control"
                                                            data-toggle="input-mask"
                                                            data-mask-format="0000 0000 0000 0000"
                                                            placeholder="4242 4242 4242 4242">
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="card-name-on" class="form-label">Name on
                                                            card</label>
                                                        <input type="text" id="card-name-on" class="form-control"
                                                            placeholder="Master Shreyu">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="card-expiry-date" class="form-label">Expiry
                                                            date</label>
                                                        <input type="text" id="card-expiry-date" class="form-control"
                                                            data-toggle="input-mask" data-mask-format="00/00"
                                                            placeholder="MM/YY">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="card-cvv" class="form-label">CVV code</label>
                                                        <input type="text" id="card-cvv" class="form-control"
                                                            data-toggle="input-mask" data-mask-format="000"
                                                            placeholder="012">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-check">
                                                        <input type="radio" id="BillingOptRadio3" name="billingOptions"
                                                            class="form-check-input">
                                                        <label class="form-check-label font-16 fw-bold"
                                                            for="BillingOptRadio3">Pay with Payoneer</label>
                                                    </div>
                                                    <p class="mb-0 ps-3 pt-1">You will be redirected to Payoneer
                                                        website to complete your purchase securely.</p>
                                                </div>
                                                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                    <img src="assets/images/payments/payoneer.png" height="30"
                                                        alt="paypal-img">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-check">
                                                        <input type="radio" id="BillingOptRadio4" name="billingOptions"
                                                            class="form-check-input">
                                                        <label class="form-check-label font-16 fw-bold"
                                                            for="BillingOptRadio4">Cash on Delivery</label>
                                                    </div>
                                                    <p class="mb-0 ps-3 pt-1">Pay with cash when your order is
                                                        delivered.</p>
                                                </div>
                                                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                    <img src="assets/images/payments/cod.png" height="22"
                                                        alt="paypal-img">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-6">
                                                <a href="apps-ecommerce-shopping-cart.html"
                                                    class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                    <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                            </div> 
                                            <div class="col-sm-6">
                                                <div class="text-sm-end">
                                                    <a href="apps-ecommerce-checkout.html" class="btn btn-danger">
                                                        <i class="mdi mdi-cash-multiple me-1"></i> Complete Order
                                                    </a>
                                                </div>
                                            </div> 
                                        </div> 

                                    </div> 

                                    <div class="col-lg-4">
                                        <div class="border p-3 mt-4 mt-lg-0 rounded">
                                            <h4 class="header-title mb-3">Order Summary</h4>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-centered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img src="assets/images/products/product-1.jpg"
                                                                    alt="contact-img" title="contact-img"
                                                                    class="rounded me-2" height="48" />
                                                                <p class="m-0 d-inline-block align-middle">
                                                                    <a href="apps-ecommerce-products-details.html"
                                                                        class="text-body fw-semibold">Amazing Modern
                                                                        Chair</a>
                                                                    <br>
                                                                    <small>5 x $148.66</small>
                                                                </p>
                                                            </td>
                                                            <td class="text-end">
                                                                $743.30
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img src="assets/images/products/product-2.jpg"
                                                                    alt="contact-img" title="contact-img"
                                                                    class="rounded me-2" height="48" />
                                                                <p class="m-0 d-inline-block align-middle">
                                                                    <a href="apps-ecommerce-products-details.html"
                                                                        class="text-body fw-semibold">Designer
                                                                        Awesome Chair</a>
                                                                    <br>
                                                                    <small>2 x $99.00</small>
                                                                </p>
                                                            </td>
                                                            <td class="text-end">
                                                                $198.00
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img src="assets/images/products/product-3.jpg"
                                                                    alt="contact-img" title="contact-img"
                                                                    class="rounded me-2" height="48" />
                                                                <p class="m-0 d-inline-block align-middle">
                                                                    <a href="apps-ecommerce-products-details.html"
                                                                        class="text-body fw-semibold">Biblio Plastic
                                                                        Armchair</a>
                                                                    <br>
                                                                    <small>1 x $129.99</small>
                                                                </p>
                                                            </td>
                                                            <td class="text-end">
                                                                $129.99
                                                            </td>
                                                        </tr>
                                                        <tr class="text-end">
                                                            <td>
                                                                <h6 class="m-0">Sub Total:</h6>
                                                            </td>
                                                            <td class="text-end">
                                                                $1071.29
                                                            </td>
                                                        </tr>
                                                        <tr class="text-end">
                                                            <td>
                                                                <h6 class="m-0">Shipping:</h6>
                                                            </td>
                                                            <td class="text-end">
                                                                FREE
                                                            </td>
                                                        </tr>
                                                        <tr class="text-end">
                                                            <td>
                                                                <h5 class="m-0">Total:</h5>
                                                            </td>
                                                            <td class="text-end fw-semibold">
                                                                $1071.29
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                             
                                        </div>  

                                    </div> 
                                </div> 
                            </div> -->

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container -->

</div> <!-- content -->

@endsection