<?php
defined("BASEPATH") or exit("No direct script access allowed");
/* 
| ------------------------------------------------------------------- 
|  Stripe API Configuration 
| ------------------------------------------------------------------- 
| 
| You will get the API keys from Developers panel of the Stripe account 
| Login to Stripe account (https://dashboard.stripe.com/) 
| and navigate to the Developers >> API keys page 
| 
|  stripe_api_key            string   Your Stripe API Secret key. 
|  stripe_publishable_key    string   Your Stripe API Publishable key. 
|  stripe_currency           string   Currency code. 
|
|  By Markad
*/
$config["stripe_publishable_key"] =
    "pk_test_51LQzpALsr5tFgVvFaH8Vgnq0vVTFwHCftkgsG7lr3fTklZdwqAI9sq3wriAWGzrQJn5yp55tJYAlNvolSgQ4jlzv00pG7ggr5R";
$config["stripe_api_key"] =
    "sk_test_51LQzpALsr5tFgVvFG2WyKg2otyW8CgFZ29s70mhCCuoPUTrmxiBp3svFo4aZV9oMHhb444wIlibnP3YLSYV9sUcz00ZksqBl8b";
$config["stripe_currency"] = "usd";
