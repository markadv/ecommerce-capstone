        <!-- Product info -->
        <div class="container mt-3">
            <div class="row">
                <!-- Gallery using swiper.js-->
                <div class="col-12 col-md-4">
                    <div
                        style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                        class="swiper mySwiper2"
                    >
                        <div class="swiper-wrapper">
<?php foreach ($pictures as $row) { ?>
                            <div class="swiper-slide">
                                <img src="<?= base_url() ?>/assets/imgs/<?= $row ?>" />
                            </div>
<?php } ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">
<?php foreach ($pictures as $row) { ?>
                            <div class="swiper-slide">
                                <img src="<?= base_url() ?>/assets/imgs/<?= $row ?>" />
                            </div>
<?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Product -->
                <div class="col-12 col-md-8 border">
                    <div>
                        <h1><?= $product["name"] ?></h1>
                        <a href="" class="detail-rating text-decoration-none">
                            <span class="material-icons-sharp"> grade </span>
                            <span class="material-icons-sharp"> grade </span>
                            <span class="material-icons-sharp"> grade </span>
                            <span class="material-icons-sharp"> grade </span>
                            <span class="material-icons-sharp"> grade </span>
                            <span>(2)</span>
                        </a>
                        <span><?= isset($sold) ? $sold : 0 ?> sold</span>
                    </div>
                    <h3>Price</h3>
                    <form action="<?= base_url() ?>products/add_item" method="post" class="needs-validation">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                        <input 
                            type="hidden"
                            name="product_id"
                            value="<?= $product["id"] ?>" />
                        <div class="row">
                            <p class="col-2">Quantity</p>
                            <div class="col-10">
                                <input
                                    type="number"
                                    name="quantity"
                                    value="<?= isset($cart) &&
                                    isset($cart[$product["id"]])
                                    	? $cart[$product["id"]]
                                    	: 1 ?>"
                                    min="1"
                                    max="<?= $product["quantity"] - $sold ?>"
                                    step="1" required/>
                                <span><?= $product["quantity"] -
                                	$sold ?> pieces available</span>
                            </div>
                        </div>
                        <div class="row">
                            <p>
                                <?= $product["description"] ?>
                            </p>
                        </div>
                        <div id="add_to_cart">
                            <a href="javascript:" id="add-shopping-cart" data-id="<?= $product[
                            	"id"
                            ] ?>"class="btn btn-outline-primary"
                                ><span class="material-icons-outlined"> add_shopping_cart </span>Add to Cart</a
                            >
                            <button type="submit" id="buy-now" class="btn btn-primary">Buy Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Reviews -->
        <div class="container mt-3"> 
            <div class="accordion" id="review-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button text-white bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#review-collapse" aria-expanded="true" aria-controls="collapseOne">
                        Reviews
                    </button>
                    </h2>
                    <div id="review-collapse" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#review-accordion">
                        <div class="accordion-body">
                        <h3>Post a review</h3>
                        <form>
                            <div class="form-floating">
                                <input type="hidden" name="product_id" value="<?= $product[
                                	"id"
                                ] ?>" />
                                <textarea
                                    name="review"
                                    class="form-control"
                                    id="floatingInput"
                                    placeholder="A super cool cap."
                                    style="height: 100px"
                                ></textarea>
                                <label for="floatingInput">Leave a review</label>
                                <input type="submit" class="mt-3 w-20 btn btn-sm btn-primary" value="Post review" />
                            </div>
                        </form>
                        <div>
                            <h2 class="h5 mb-0 mt-3">Mark Timothy Advento</h2>
                            <p class="lead border mb-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit iste reiciendis
                                dignissimos natus, distinctio modi blanditiis aliquam, voluptatum, corporis nobis atque at
                                inventore omnis cum eligendi. Culpa quia delectus pariatur.
                            </p>
                            <span class="mb-3">30 minutes ago</span>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-9">
                                <h2 class="h5 mb-0 mt-3">John Wick</h2>
                                <p class="lead border mb-0">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur cum nemo
                                    consequuntur nam molestias laborum obcaecati sunt. Voluptates modi quod, nemo sunt
                                    minima id voluptate ullam minus repellendus vel explicabo.
                                </p>
                                <span class="mb-3">5 minutes ago</span>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <form class="col-9">
                                <div class="form-floating">
                                    <input type="hidden" name="review_id" value="id" />
                                    <textarea
                                        name="reply"
                                        class="form-control"
                                        id="floatingInput"
                                        placeholder="A super cool cap."
                                        style="height: 100px"
                                    ></textarea>
                                    <label for="floatingInput">Leave a reply</label>
                                    <input
                                        type="submit"
                                        class="mt-3 w-20 btn btn-sm btn-outline-primary"
                                        value="Post reply"
                                    />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Related products -->
        <div class="container">
            <h2>Similar items</h2>
            <ul class="row align-items-center">
                <li class="col-4 col-md-2 text-decoration-none list-unstyled">
                    <div class="card">
                        <img class="card-img-top" src="../Assets/imgs/product1.jpg" alt="mouse" />
                        <div class="card-body">
                            <a href="show_product.html" class="d-block">
                                <h6 class="card-title text-center">Anti-colic baby bottle</h6>
                            </a>
                            <div class="text-center">
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                            </div>
                            <p class="card-text text-center">Price: $4.99</p>
                        </div>
                    </div>
                </li>
                <li class="col-4 col-md-2 text-decoration-none list-unstyled">
                    <div class="card">
                        <img class="card-img-top" src="../Assets/imgs/product1.jpg" alt="mouse" />
                        <div class="card-body">
                            <a href="show_product.html" class="d-block">
                                <h6 class="card-title text-center">Anti-colic baby bottle</h6>
                            </a>
                            <div class="text-center">
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                            </div>
                            <p class="card-text text-center">Price: $4.99</p>
                        </div>
                    </div>
                </li>
                <li class="col-4 col-md-2 text-decoration-none list-unstyled">
                    <div class="card">
                        <img class="card-img-top" src="../Assets/imgs/product1.jpg" alt="mouse" />
                        <div class="card-body">
                            <a href="show_product.html" class="d-block">
                                <h6 class="card-title text-center">Anti-colic baby bottle</h6>
                            </a>
                            <div class="text-center">
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                            </div>
                            <p class="card-text text-center">Price: $4.99</p>
                        </div>
                    </div>
                </li>
                <li class="col-4 col-md-2 text-decoration-none list-unstyled">
                    <div class="card">
                        <img class="card-img-top" src="../Assets/imgs/product1.jpg" alt="mouse" />
                        <div class="card-body">
                            <a href="show_product.html" class="d-block">
                                <h6 class="card-title text-center">Anti-colic baby bottle</h6>
                            </a>
                            <div class="text-center">
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                            </div>
                            <p class="card-text text-center">Price: $4.99</p>
                        </div>
                    </div>
                </li>
                <li class="col-4 col-md-2 text-decoration-none list-unstyled">
                    <div class="card">
                        <img class="card-img-top" src="../Assets/imgs/product1.jpg" alt="mouse" />
                        <div class="card-body">
                            <a href="show_product.html" class="d-block">
                                <h6 class="card-title text-center">Anti-colic baby bottle</h6>
                            </a>
                            <div class="text-center">
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                            </div>
                            <p class="card-text text-center">Price: $4.99</p>
                        </div>
                    </div>
                </li>
                <li class="col-4 col-md-2 text-decoration-none list-unstyled">
                    <div class="card">
                        <img class="card-img-top" src="../Assets/imgs/product1.jpg" alt="mouse" />
                        <div class="card-body">
                            <a href="show_product.html" class="d-block">
                                <h6 class="card-title text-center">Anti-colic baby bottle</h6>
                            </a>
                            <div class="text-center">
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                            </div>
                            <p class="card-text text-center">Price: $4.99</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </body>
</html>
