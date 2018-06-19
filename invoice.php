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

if ($_GET['id'] == null) {
    header('Location: /invoices.php');
}

require_once(dirname(__FILE__) . '/util.php');

include_once(dirname(__FILE__) . '/includes/client.php');

use Killbill\Client\Invoice;

ensureLoggedIn();

include_once(dirname(__FILE__) . '/includes/header.php');
include_once(dirname(__FILE__) . '/includes/nav.php');

?>

<div class="container">
    <div class="well">
    <?php

    $invoice = new Invoice();
    $invoice->invoiceId = $_GET['id'];
    $invoice = $invoice->get(true, $tenantHeaders);

    if ($invoice == null) {
        echo 'Invoice does not exist.';
    } else {
        echo $invoice->getInvoiceAsHTML($tenantHeaders);
    }
    ?>
    </div>
</div>

<?php
include_once(dirname(__FILE__) . '/includes/footer.php');
?>
