@extends('layouts.celmovil')
@section('content')
    <!-- Preloader Start
    <div class="preloader">
        <div class="loading-center">
            <div class="loading-center-absolute">
                <div class="object object_one"></div>
                <div class="object object_two"></div>
                <div class="object object_three"></div>
            </div>
        </div>
    </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

		<!-- page banner area start -->
		<div class="page-banner">
			<img src="img/slider/bg3.jpg" alt="Page Banner" />
		</div>
		<!-- page banner area end -->
		<!-- cart page content section start -->
		<section class="cart-page section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive table-one margin-minus section-padding-bottom">
							<table class="spacing-table text-center">
								<thead>
									<tr>
										<th>Image</th>
										<th>Name</th>
										<th>Unit Price</th>
										<th>QTY</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-img text-left">
											<a href="#"><img src="img/cart/1.jpg" alt="Add Product" /></a>
											<div class="items-dsc">
												<p><a href="#">Sensor Carbon Jenson GX1 Bike</a></p>
											</div>
										</td>
										<td>$56.00</td>
										<td>
											<form action="#" method="POST">
												<div class="plus-minus">
													<a class="dec qtybutton">-</a>
													<input type="text" value="02" name="qtybutton" class="plus-minus-box">
													<a class="inc qtybutton">+</a>
												</div>
											</form>
										</td>
										<td>$112.00</td>
										<td><i class="fa fa-trash" title="Remove this product"></i></td>
									</tr>
									<tr>
										<td class="td-img text-left">
											<a href="#"><img src="img/cart/1.jpg" alt="Add Product" /></a>
											<div class="items-dsc">
												<p><a href="#">Sensor Carbon Jenson GX1 Bike</a></p>
											</div>
										</td>
										<td>$56.00</td>
										<td>
											<form action="#" method="POST">
												<div class="plus-minus">
													<a class="dec qtybutton">-</a>
													<input type="text" value="02" name="qtybutton" class="plus-minus-box">
													<a class="inc qtybutton">+</a>
												</div>
											</form>
										</td>
										<td>$112.00</td>
										<td><i class="fa fa-trash" title="Remove this product"></i></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="estimate-text">
							<h3>Estimate Shipping And Tax</h3>
							<p>Enter your destination to get shipping & tax</p>
							<form action="mail.php" method="post">
								<div class="single-select">
									<label>Country *</label>
									<div class="custom-select">
										<select class="form-control">
											<option>Options</option>
											<option>Aruba</option>
											<option>Australia </option>
											<option>Bahrain</option>
											<option>Bangladesh</option>
											<option>Chile</option>
										</select>
									</div>
								</div>
								<div class="single-select">
									<label>State/Province *</label>
									<div class="custom-select">
										<select class="form-control">
											<option>Options</option>
											<option>Kerala</option>
											<option>Madhya</option>
											<option>Manipur</option>
											<option>Dhaka</option>
											<option>Chili</option>
										</select>
									</div>
								</div>
								<div class="single-select">
									<label>Zip/Postal Code</label>
									<div class="input-text">
										<input type="text" name="zip" />
									</div>
									<div class="submit-text quotes">
										<input type="submit" name="submit" value="Get A Quote">
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="estimate-text coupon">
							<h3>Discount Code</h3>
							<p>Enter your coupon code if you have one</p>
							<form action="mail.php" method="post">
								<div class="input-text">
									<input type="text" name="coupon" />
								</div>
								<div class="submit-text">
									<input type="submit" name="submit" value="Apply Coupon">
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="estimate-text responsive">
							<div class="subtotal clearfix">
								<p>Subtotal: <span class="floatright">$156.87</span></p>
								<p>Grandtotal: <span class="floatright">$156.87</span></p>
							</div>
							<div class="default-btn text-right">
								<a class="btn-style" href="checkout.html">PROCCED TO CHECKOUT</a>
							</div>
							<p><strong>Checkout with multiples address</strong></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- cart page content section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->
        
@stop