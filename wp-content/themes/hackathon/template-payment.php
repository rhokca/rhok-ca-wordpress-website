<?php
/*
Template Name: Payment
*/


include dir(__FILE__)."/stripekeys.php"

class Stripe {
    public $headers;
    public $url = 'https://api.stripe.com/v1/charges';
    public $fields = array();

    function __construct () {
        $this->headers = array('Authorization: Bearer '.STRIPE_API_KEY_SK); // STRIPE_API_KEY = your stripe api key
    }

    function call () {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true); // return php array with api response
    }
}

if(isset($_POST["type"])&&$_POST["type"]=="card"){
   // create customer and use email to identify them in stripe
  $s = new Stripe();
  $s->fields['amount'] = $_POST['amount'];
  $s->fields['currency'] = $_POST["currency"];
  $s->fields['source'] = $_POST['id'];
  $s->fields['description'] = "Charge for ".$_POST['email'];
  var_dump($s->fields);
  $charge = $s->call();
  exit;
}

get_header();
?>
<article class="page-content container" style="text-align: center;">

<div id="thank-you" style="display:none;" class="wc-shortcodes-box wc-shortcodes-item wc-shortcodes-content wc-shortcodes-clearfix wc-shortcodes-box-success ">
<p>Thank you. Your payment was sent.</p> 
</div>

<div id="working" style="display:none;"><p>Finalizing payment...</p></div>

<div id="payment-form">
<style>
  .intro { height: 100px; }
  #amount, #currency { width:100px; text-align: right; display: inline; }
</style>

<script src="https://checkout.stripe.com/checkout.js"></script>

$&nbsp;<input type="number" id="amount" min="1" step="1" max="2500" value="1000" />

<select name="currency" id="currency"><option value="cad">CAD</option><option value="usd">USD</option></select>

<button id="customButton">Purchase</button>

<script>
var handler = StripeCheckout.configure({
  key: '<?php echo STRIPE_API_KEY_PK; ?>',
  image: 'https://rhok.ca/wp-content/uploads/2018/04/rhok-logo-128.png',
  locale: 'auto',
  token: function(token) {
        token.amount = $("#amount").val()*100;
        token.currency = $("#currency").val();
	$("#payment-form").hide();
        $("#working").show();
	$("#thank-you").hide();
        $.ajax({
          type: "POST",
          url: "https://rhok.ca/payment/",
          data: token,
          success: function(response){
            $("#working").hide();
            $("#thank-you").show();
            $("#payment-form").show();
          }
        });
  }
});

var amount = 0;

document.getElementById('customButton').addEventListener('click', function(e) {
  $("#thank-you").hide();
  // Open Checkout with further options:
  handler.open({
    name: 'rhok.ca',
    description: 'Payment to RHoK',
    currency: $("#currency").val(),
    amount: $("#amount").val()*100
  });
  e.preventDefault();
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});
</script>
</div>

</article>


<?php get_footer(); ?>
