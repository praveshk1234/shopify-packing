<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "65e963264353bdd2930b24affacb1acd";
$scopes = "write_orders,read_orders,write_products";
$redirect_uri = "https://staging.vipankumar.com/packingslip/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();
