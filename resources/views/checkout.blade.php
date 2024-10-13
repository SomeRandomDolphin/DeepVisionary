<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        crossorigin="anonymous" />
    <div class="container">
        <!-- <div class="py-5 text-center text-white">
            <h2>Checkout form</h2>
        </div> -->
        <div class="row mt-4">
            <div class="col-md-4 order-md-2 mb-4">
            </div>
            <div class="col-md-8 order-md-1 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                </h4>
                <ul class="list-group mb-3 sticky-top">
                    <li class="list-group-item d-flex justify-content-between lh-condensed bg-dark">
                        <div class="text-white">
                            <h6 class="my-0">Product name</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">Rp.6000000</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed bg-dark">
                        <div class="text-white">
                            <h6 class="my-0">Second product</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">Rp.8000000</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed bg-dark">
                        <div class="text-white">
                            <h6 class="my-0">Third item</h6>
                            <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">Rp.6000000</span>
                    </li>
                    <!-- <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">-$5</span>
                    </li> -->
                    <li class="list-group-item d-flex justify-content-between bg-dark text-white">
                        <span>Total (Rp)</span>
                        <strong>Rp.20000000</strong>
                    </li>
                </ul>
                <!-- <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form> -->
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>