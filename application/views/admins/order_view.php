<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Order #1</title>
        <!-- Latest jQuery CDN -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"
        ></script>
        <!-- Latest Bootstrap CDN -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
            crossorigin="anonymous"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <!-- Latest Material Icons (icons) CDN -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
        <!-- Google fonts CDN -->
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap"
            rel="stylesheet"
        />
        <!-- LESS Stylesheets CDN -->
        <link rel="stylesheet/less" href="../Assets/styles/header.less" />
        <link rel="stylesheet/less" href="../Assets/styles/order_view.less" />
        <link rel="stylesheet/less" href="../Assets/styles/custom_colors.less" />
        <script src="https://cdn.jsdelivr.net/npm/less"></script>
        <!-- Bootstrap JS CDN -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"
        ></script>
        <!-- JS Script -->
        <script src="../Assets/scripts/loginbar.js"></script>
        <script src="../Assets/scripts/navbar_admin.js"></script>
    </head>
    <body>
        <!-- Insert login bar partial view -->
        <header>
            <div id="loginbar"></div>
            <div id="navbar"></div>
        </header>
        <!-------------Order Info---------------->
        <div class="container py-3">
            <div class="row">
                <div class="col-3">
                    <ul class="list-group">
                        <li class="list-group-item">Order ID: 1</li>
                        <li class="list-group-item">Shipping info:</li>
                        <li class="list-group-item">
                            <p>Name: bob</p>
                            <p>Address: 123 dojo way</p>
                            <p>City: seatle</p>
                            <p>State: wa</p>
                            <p>Zip: 98133</p>
                        </li>
                        <li class="list-group-item">Billing info:</li>
                        <li class="list-group-item">
                            <p>Name: bob</p>
                            <p>Address: 123 dojo way</p>
                            <p>City: seatle</p>
                            <p>State: wa</p>
                            <p>Zip: 98133</p>
                        </li>
                    </ul>
                </div>
                <div class="col-9">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Cup</td>
                                <td>&#8369;100</td>
                                <td>5</td>
                                <td>&#8369;500</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Cup</td>
                                <td>&#8369;100</td>
                                <td>5</td>
                                <td>&#8369;500</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Cup</td>
                                <td>&#8369;100</td>
                                <td>5</td>
                                <td>&#8369;500</td>
                            </tr>
                        </tbody>
                    </table>
                    <ul class="list-group d-inline-block">
                        <li class="list-group-item bg-success text-white">Status: Shipped</li>
                        <li class="list-group-item">
                            <p>Subtotal: &#8369;1000.00</p>
                            <p>Shipping: &#8369;100.00</p>
                            <p>Total price: &#8369;1100.00</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
