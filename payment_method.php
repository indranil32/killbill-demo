<?php
/*
 * Copyright 2011-2012 Ning, Inc.
 *
 * Ning licenses this file to you under the Apache License, version 2.0
 * (the "License"); you may not use this file except in compliance with the
 * License.  You may obtain a copy of the License at:
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once(dirname(__FILE__) . '/util.php');

include_once(dirname(__FILE__) . '/includes/client.php');

ensureLoggedIn();

include_once(dirname(__FILE__) . '/includes/header.php');
include_once(dirname(__FILE__) . '/includes/nav.php');

use Killbill\Client\PaymentMethod;
use Killbill\Client\Type\PaymentMethodPluginDetailAttributes;
use Killbill\Client\Type\PluginPropertyAttributes;

?>


<div class="container">
<?php

$account = loadAccount($tenantHeaders);


$pm_created = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $paymentMethodData = new PaymentMethod();
  $paymentMethodData->accountId = $account->accountId;
  $paymentMethodData->isDefault = true;
  $paymentMethodData->pluginName = 'killbill-coinbase';

  $propApiKey = new PluginPropertyAttributes();
  $propApiKey->key = 'apiKey';
  $propApiKey->value = $_POST['btcApiKey'];
  $propApiKey->isUpdatable = false;

  $paymentMethodData->pluginInfo = new PaymentMethodPluginDetailAttributes();
  $paymentMethodData->pluginInfo->properties = array($propApiKey);

  $paymentMethod = $paymentMethodData->create("web-user", "PHP_TEST", "Test for the demo", $tenantHeaders);
  if ($paymentMethod->paymentMethodId != null) {
      $pm_created = TRUE;
  } else {
      $pm_created = FALSE;
  }
} else {
    $paymentMethod = new PaymentMethod();
}
?>


<div class="container">
<?php
if ($pm_created === FALSE) {
?>
<div class="alert alert-error">
  Your payment method count couldn't be created :(
</div>
<?php
} elseif ($pm_created === TRUE) {
// Redirect the user to his subscriptions page
//header('Location: /payment_method.php');
?>
<div class="alert alert-success">
  You payment method has been created! Your payment method id is <?php echo $paymentMethod->paymentMethodId; ?>
</div>
<?php
}
?>

 <form class="form-horizontal" method="post" action="payment_method.php">
   <fieldset>
             <legend>Enter your payment method:</legend>
            <div class="control-group">
                <label class="control-label" for="btcApiKey">BTC API Key</label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="btcApiKey" name="btcApiKey"
                           value="">
                    <p class="help-block">The API key you got from your hosted wallet provider</p>
                </div>
                <div class="form-actions">
                    <input type="submit" class="btn btn-primary" value="Create">
                </div>

            </div>
   </fieldset>
     </form>
 </div>
 <!-- /container -->


<?php
include_once(dirname(__FILE__) . '/includes/footer.php');
?>
