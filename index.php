<?php
session_start();
include('include/header.php');
?>
<title>Stripe Payment Gateway Integration</title>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.0.0/jquery.creditCardValidator.js"></script>
<script type="text/javascript" src="script/payment.js"></script>
<?php include('include/container.php'); ?>

<div class="container" style="margin-top: 20px">
    <div class="row" style="">

        <?php
        if (isset($_SESSION["message"]) && $_SESSION["message"] && $_SESSION["message"] == 'failed') {
            ?>
            <div class="alert alert-danger">
                <?php
                echo "Error : Payment failed!";
                $_SESSION["message"] = '';
                ?>
            </div>
            <?php
        } elseif (isset($_SESSION["message"]) && $_SESSION["message"]) {
            ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION["message"];
                $_SESSION["message"] = '';
                ?>
            </div>
        <?php } ?>
        <div class="panel panel-default col-md-6" style="padding-right: 0px;padding-left: 0px;">
            <div class="panel-heading">Checkout</div>
            <div class="panel-body">
                <form action="process.php" method="POST" id="paymentForm">
                    <div class="row">
                        <div class="col-md-12" style="border-right:1px solid #ddd;padding: 0px 40px">
                            <fieldset style="border-bottom:1px solid #ddd;">
                                <input type="radio" id="Combo" name="fav_language" value="Combo"
                                       style="margin-left: 8px" checked="checked">
                                  <label for="Combo">About Life - Combo.....$14.95</label><br>
                                  <input type="radio" id="eBook" name="fav_language" value="eBook">
                                  <label for="eBook">About Life - eBook.....$9.95</label><br>
                                  <input type="radio" id="Audiobook" name="fav_language" value="Audiobook">
                                  <label for="Audiobook">About Life - Audiobook.....$8.95</label>
                            </fieldset>
                            <h4 align="center">Contact</h4>
                            <div class="form-group">
                                <input type="text" name="customerName" id="customerName" class="form-control" value=""
                                       placeholder="First Name">
                                <span id="errorCustomerName" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="customerLastName" id="customerLastName" class="form-control"
                                       value="" placeholder="Last Name">
                                <span id="errorCustomerLastName" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="emailAddress" id="emailAddress" class="form-control" value=""
                                       placeholder="Email Address ">
                                <span id="errorEmailAddress" class="text-danger"></span>
                            </div>
                            <hr>
                            <fieldset style="background-color: #EFF8FF">
                                <h4 align="center">Card Details</h4>

                                <div class="form-group" style="padding: 0px 10px">
                                    <input type="text" name="cardNumber" id="cardNumber" class="form-control"
                                           placeholder="Card Number" maxlength="20" onkeypress="">
                                    <span id="errorCardNumber" class="text-danger"></span>
                                </div>
                                <div class="form-group" style="padding: 0px 10px">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="cardExpMonth" id="cardExpMonth"
                                                   class="form-control"
                                                   placeholder="MM" maxlength="2"
                                                   onkeypress="return validateNumber(event);">
                                            <span id="errorCardExpMonth" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="cardExpYear" id="cardExpYear" class="form-control"
                                                   placeholder="YYYY" maxlength="4"
                                                   onkeypress="return validateNumber(event);">
                                            <span id="errorCardExpYear" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="cardCVC" id="cardCVC" class="form-control"
                                                   placeholder="CVC" maxlength="4"
                                                   onkeypress="return validateNumber(event);">
                                            <span id="errorCardCvc" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <br>
                            <h4>Order Summary</h4>
                            <h4 style="font-weight: bold">Total:<span style="float: right;font-size: 20px"
                                                                      class="text-info" id="totalAmnt"></span></h4>

                            <br>
                            <div align="center">
                                <input type="hidden" name="price" value="">
                                <input type="hidden" name="total_amount" value="">
                                <input type="hidden" name="currency_code" value="USD">
                                <input type="hidden" name="item_details" value="">
                                <input type="hidden" name="item_number" value="">
                                <input type="hidden" name="order_number" value="">
                                <input type="button" name="payNow" id="payNow"
                                       style="background-color: #2096EE;color: snow;border-radius: 50px"
                                       class="btn btn-sm"
                                       onclick="stripePay(event)" value="Place Order Now"/>
                            </div>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('include/footer.php'); ?>

