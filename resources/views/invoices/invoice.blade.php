<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php use App\Http\Controllers\Controller; ?>
<style media="all">
@import url('https://fonts.gstatic.com/s/ubuntu/v10/4iCs6KVjbNBYlgoKcg72nU6AF7xm.woff2');
	*{
		margin: 0;
		padding: 0;
		line-height: 1.5;
		font-family: 'WebFont-Ubuntu';
		color: #333542;
	}
  .pcs-template {
  	font-family: Ubuntu, 'WebFont-Ubuntu';
    font-size: 8pt;
    color: #000000;
      background:  #ffffff ;
  }

  .pcs-header-content {
    font-size: 8pt;
	color: #000000;
	background-color: #ffffff;
  }
  .pcs-template-body {
  	padding: 0 0.400000in 0 0.550000in;
  }
  .pcs-template-footer {
  	height: 0.700000in;
	font-size: 6pt;
	color: #000000;
	padding: 0 0.400000in 0 0.550000in;
	background-color: #ffffff;
  }
  .pcs-footer-content {
  word-wrap: break-word;
  color: #000000;
      border-top: 1px solid #9e9e9e;
  }

  .pcs-label {
    color: #333333;
  }
  .pcs-entity-title {
    font-size: 22pt;
    color: #000000;
  }
  .pcs-orgname {
    font-size: 12pt;
    color: #000000;
  }
  .pcs-customer-name {
    font-size: 9pt;
    color: #000000;
  }
 .pcs-itemtable-header {
    font-size: 8pt;
    color: #000000;
    background-color: #f2f3f4;
  }
  .pcs-itemtable-breakword {
    word-wrap: break-word;
  }
  .pcs-taxtable-header {
    font-size: 8pt;
    color: #000000;
    background-color: #f2f3f4;
  }
  .breakrow-inside {
    page-break-inside: avoid;
  }
  .breakrow-after {
    page-break-after:auto;
  }
  .pcs-item-row {
    font-size: 8pt;
    border-bottom: 1px solid #9e9e9e;
    background-color: #ffffff;
    color: #000000;
  }
  .pcs-item-sku {
    margin-top: 2px;
  	font-size: 10px;
  	color: #444444;
  }
  .pcs-item-desc {
      color: #727272;
      font-size: 8pt;
   }
  .pcs-balance {
    background-color: #ffffff;
    font-size: 9pt;
    color: #000000;
  }
  .pcs-totals {
    font-size: 8pt;
    color: #000000;
    background-color: #ffffff;
  }
  .pcs-notes {
    font-size: 8pt;
  }
  .pcs-terms {
    font-size: 8pt;
  }
  .pcs-header-first {
	background-color: #ffffff;
	font-size: 8pt;
	color: #000000;
      height: auto;
	}

 .pcs-status {
 	color: ;
	font-size: 15pt;
	border: 3px solid ;
	padding: 3px 8px;
 }
 .billto-section {
     padding-top: 0mm;
     padding-left: 0mm;
   }
   .shipto-section {
     padding-top: 0mm;
     padding-left: 0mm;
   }

 @page :first {
 	
    margin-top: 0.700000in;
  }

  .pcs-template-header {
	padding: 0 0.400000in 0 0.550000in;
    height: 0.700000in;
  }

  .pcs-template-fill-emptydiv {
    display: table-cell;
    content: " ";
    width: 100%;
  }


/* Additional styles for RTL compat */

/* Helper Classes */

.inline {
  display: inline-block;
}
.v-top {
  vertical-align: top;
}
.text-align-right {
  text-align: right;
}
.rtl .text-align-right {
  text-align: left;
}
.text-align-left {
  text-align: left;
}
.rtl .text-align-left {
  text-align: right;
}

/* Helper Classes End */

.item-details-inline {
  display: inline-block;
  margin: 0 10px;
  vertical-align: top;
  max-width: 70%;
}

.total-in-words-container {
  width: 100%;
  margin-top: 10px;
}
.total-in-words-label {
  vertical-align: top;
  padding: 0 10px;
}
.total-in-words-value {
  width: 170px;
}
.total-section-label {
  padding: 5px 10px 5px 0;
  vertical-align: middle;
}
.total-section-value {
  width: 120px;
  vertical-align: middle;
  padding: 10px 10px 10px 5px;
}
.rtl .total-section-value {
  padding: 10px 5px 10px 10px;
}

.tax-summary-description {
  color: #727272;
  font-size: 8pt;
}

.bharatqr-bg {
  background-color: #f4f3f8;
}

/* Overrides/Patches for RTL compat */
  .rtl th {
    text-align: inherit; /* Specifically setting th as inherit for supporting RTL */
  }
/* Overrides/Patches End */

  /* Signature styles */
  .sign-border {
    width: 200px;
    border-bottom: 1px solid #000;
  }
  .sign-label {
    display: table-cell;
    font-size: 10pt;
    padding-right: 5px;
  }
  /* Signature styles End */

/* Subject field styles */
.subject-block {
    margin-top: 20px;
}
.subject-block-value {
    word-wrap: break-word;
    white-space: pre-wrap;
    line-height: 14pt;
    margin-top:5px;
}
/* Subject field styles End*/


  .pcs-template-bodysection {
       border: 1px solid #9e9e9e;
  }
  .pcs-itemtable {
    border-top: 1px solid #9e9e9e;
  }
  .pcs-addresstable {
    width: 100%;
    table-layout:fixed;
  }
  .pcs-addresstable > thead > tr > th {
    padding: 1px 5px;
    background-color: #f2f3f4;
    font-weight: normal;
    border-bottom: 1px solid #9e9e9e;
  }
  .pcs-addresstable > tbody > tr > td {
    line-height: 15px;
    padding: 5px 5px 0px 5px;
    vertical-align:top;
    word-wrap: break-word;
  }

  .invoice-detailstable > tbody > tr > td {
    width: 50%;
    vertical-align: top;
    border-top: 1px solid #9e9e9e;
  }

  .invoice-detailstable > tbody > tr > td > span{
    width: 45%;
    padding: 1px 5px;
    display: inline-block;
    vertical-align: top;
  }

  .pcs-itemtable-header {
    font-weight: normal;
    border-right: 1px solid #9e9e9e;
    border-bottom: 1px solid #9e9e9e;
  }
  .pcs-itemtable-subheader {
    padding: 1px 5px;
    text-align: right;
  }
  .pcs-item-row {
    border-right: 1px solid #9e9e9e;
    border-bottom: 1px solid #9e9e9e;
  }
  .pcs-itemtable tr td.pcs-itemtable-subheader:last-child {
    border-right: 1px solid #9e9e9e;
  }
  .pcs-itemtable tr td.pcs-itemtable-subrow:last-child {
    border-right: 1px solid #9e9e9e;
  }
  .pcs-itemtable tr td:last-child, .pcs-itemtable tr th:last-child {
    border-right: 0px;
  }
  .pcs-itemtable tr td:first-child, .pcs-itemtable tr th:first-child {
    border-left: 0px;
  }
  .pcs-itemtable tbody > tr > td {
    padding: 1px 5px;
    word-wrap: break-word;
  }
  .pcs-totaltable tbody > tr > td {
    padding: 4px 7px 0px;
    text-align: right;
  }
  .pcs-footer-content {
    border-top: 0px;
  }
  #tmp_vat_summary_label {
    padding: 4px 4px 3px 7px;
  }
  .subject-block {
    margin-top: 0px;
    padding: 10px;
    border-top: 1px solid #9e9e9e;
  }
  .pcs-taxtable-header {
    border-bottom: 1px solid #9e9e9e;
    border-right: 1px solid #9e9e9e;
  }
</style>
</head>
<body>
<div class="pcs-template-body">
    <div class="pcs-template-bodysection">
		<table style="width: 100%;">
        <tbody>
          <tr>
            <td style="width:50%;padding: 2px 10px;vertical-align: middle;">
              <div>
                <span style="font-weight: bold;" class="pcs-orgname">{{@$invoicedetail->company->company_name}}<br></span>
                <span style="white-space: pre-wrap;" id="tmp_org_address">{{@$invoicedetail->company->address}} <br>{{@$invoicedetail->company->city}} {{@$invoicedetail->company->state}} {{@$invoicedetail->company->zip}} <br/>{{@$invoicedetail->company->country}}</span>
              </div>
            </td>
          <td style="width:40%;padding: 5px;vertical-align: bottom;" align="right">
            
            <div class="pcs-entity-title">TAX INVOICE</div>
          </td>
    </tr>
  </tbody>
</table>

<div style="width: 100%;">
	<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;table-layout: fixed;word-wrap: break-word;" class="invoice-detailstable">
		<thead>
			<tr>
				<th style="width: 50%"></th>
				<th style="width: 50%"></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="border-right: 1px solid #9e9e9e;padding-bottom: 10px;width: 50%">
					<div style="display:block;width:100%;">
						<div style="width: 48%;display:inline-block;" class="pcs-label">#</div>
						<div style="font-weight: 600;width: 50%;display:inline-block;" id="tmp_entity_number">: {{$invoicedetail->invoice}}</div>
						<div style="width: 48%;display:inline-block;" class="pcs-label">Invoice Date</div>
						<div style="font-weight: 600;width: 50%;display:inline-block;" id="tmp_entity_date">: {{date('d/m/Y',strtotime($invoicedetail->invoice_date))}}</div>
						<div style="width: 48%;display:inline-block;" class="pcs-label">Terms</div>
						<div style="font-weight: 600;width: 50%;display:inline-block;" id="tmp_payment_terms">: {{$invoicedetail->terms}}</div>
						<div style="width: 48%;display:inline-block;" class="pcs-label">Due Date</div>
						<div style="font-weight: 600;width: 50%;display:inline-block;" id="tmp_due_date">: {{date('d/m/Y',strtotime($invoicedetail->due_date))}}</div>
					</div> 
				</td>    
				<td style="padding-bottom: 10px;width: 50%">
				</td>
			</tr> 
		</tbody>
	</table>
</div>

  <div style="clear:both;"></div>

  <table style="" class="pcs-addresstable" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th style="border-right: 1px solid #9e9e9e;border-top: 1px solid #9e9e9e;"><label style="margin-bottom: 0px;display: block;" id="tmp_billing_address_label" class="pcs-label"><b>Bill To</b></label></th>
        <th style="border-top: 1px solid #9e9e9e;"><label style="margin-bottom: 0px;display: block;" id="tmp_shipping_address_label" class="pcs-label"></label></th>
      </tr>
    </thead>
      <tbody>
        <tr>
        <td style="border-right: 1px solid #9e9e9e;padding-bottom: 10px;" valign="top">
  			    <span style="white-space: pre-wrap;line-height: 15px;" id="tmp_billing_address"><strong><span class="pcs-customer-name" id="zb-pdf-customer-detail">{{@$invoicedetail->customer->company_name}}</span></strong>
{{@$invoicedetail->customer->first_name}} {{@$invoicedetail->customer->last_name}}
{{@$invoicedetail->customer->address}}</span></span>
<br> {{@$invoicedetail->customer->city}} {{@$invoicedetail->customer->zip}} <br>
															{{@$invoicedetail->customer->country}}</span>
        </td>
        <td style="padding-bottom: 10px;">
        </td>
        </tr>
      </tbody>
    </table>
	<div style="clear:both;"></div>
<?php $currencydata = \App\Currency::where('id',$invoicedetail->currency_id)->first(); ?>
  <table style="width: 100%;table-layout:fixed;clear: both;" class="pcs-itemtable" id="itemTable" cellspacing="0" cellpadding="0" border="0">
    <thead>
		  <tr style="height:17px;">
		  <td style="padding: 5px 5px 2px 5px;width: 5%;text-align: center;" valign="bottom" rowspan="2" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
			<b>#</b>
		  </td>
		  <td style="padding: 5px 7px 2px 7px;width: ;text-align: left;" valign="bottom" rowspan="2" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
			<b>Item &amp; Description</b>
		  </td>
		  <td style="padding: 5px 7px 2px 7px;width: 11%;text-align: right;" valign="bottom" rowspan="2" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
			<b>Qty</b>
		  </td>
		  <td style="padding: 5px 7px 2px 7px;width: 11%;text-align: right;" valign="bottom" rowspan="2" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
			<b>Rate</b>
		  </td>
		  <td style="padding: 5px 7px 2px 7px;width: 13%;text-align: right;" valign="bottom" rowspan="2" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
			<b>Amount</b>
		  </td>
		</tr>
		<tr>
		</tr>
	</thead>
		<tbody class="itemBody">
			<?php $ist = 1; $subtotal = 0; ?>
			@foreach($invoicedetail->invoicedetail as $lst)
				<?php $ntotal = $lst->quantity * $lst->rate; ?>
				<tr class="breakrow-inside breakrow-after" style="height:20px;">
					<td rowspan="1" valign="top" style="text-align: center;" class="pcs-item-row"> {{$ist}}</td>
					<td rowspan="1" valign="top" class="pcs-item-row" id="tmp_item_name">
						<div><div><span style="white-space: pre-wrap;word-wrap: break-word;" class="pcs-item-desc" id="tmp_item_description">{{$lst->item_name}}</span><br></div></div>
					</td>
					<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" id="tmp_item_qty">{{number_format($lst->quantity,$currencydata->decimal)}} </td>
					<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" id="tmp_item_rate">{{number_format($lst->rate,$currencydata->decimal)}}</td>
					<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" id="tmp_item_amount">{{number_format($ntotal,$currencydata->decimal)}}</td>
				</tr>
				<?php 
				$subtotal += $ntotal;
				$ist++; ?>
				@endforeach
		</tbody>
</table>
<?php 
if($invoicedetail->discount_type == 'fixed'){ 
	$discoun = $invoicedetail->discount;
	$finaltotal = $subtotal - $invoicedetail->discount;
}else{
 $discoun = ($subtotal * $invoicedetail->discount) / 100; 
 $finaltotal = $subtotal - $discoun;
} 
 if(@$invoicedetail->tax != 0)
{
	$cure = \App\TaxRate::where('id',@$invoicedetail->tax)->first(); 
	$taxcal = ($finaltotal * $cure->rate) / 100;
	$finaltotal = $finaltotal + $taxcal;
}
$amount_rec = \App\InvoicePayment::where('invoice_id',$invoicedetail->id)->get()->sum("amount_rec");
$ispaymentexist = \App\InvoicePayment::where('invoice_id',$invoicedetail->id)->exists();
?>
<div style="width: 100%;">
    <div style="width: 50%;padding: 4px 4px 3px 7px;float: left;">
        <div style="margin:10px 0 5px">
          <div style="padding-right: 10px;">Total In Words</div>
          <span><b><i>Indian <?php echo Controller::convert_number_to_words($finaltotal); ?>  Only</i></b></span>
        </div>
          <div style="padding-top: 10px;">
            <p style="white-space: pre-wrap;word-wrap: break-word;" class="pcs-notes">Thanks for your business.</p>
          </div>
    </div>
    <div style="width: 43.6%;float:right;" class="pcs-totals">
      <table style="border-left: 1px solid #9e9e9e;" class="pcs-totaltable" id="itemTable" cellspacing="0" border="0" width="100%">
        <tbody>
          <tr>
				<td valign="middle">Sub Total</td>
				<td id="tmp_subtotal" valign="middle" style="width:110px;">{{number_format($subtotal,$currencydata->decimal)}}</td>
          </tr>  
			<?php if($invoicedetail->discount != 0){ ?>
				<tr>
					<td valign="middle">Discount(<?php if($invoicedetail->discount_type == 'fixed'){ echo $currencydata->currency_symbol; } ?>{{$invoicedetail->discount}} <?php if($invoicedetail->discount_type == 'percentage'){ echo '%'; } ?>)</td>
					<td id="tmp_total" valign="middle" style="width:110px;">(-) <?php echo $discoun; ?></td>
				</tr>
			<?php } ?>
			 @if(@$invoicedetail->tax != 0)
					<?php
						
						$isex = \App\TaxRate::where('id',@$invoicedetail->tax)->exists(); 
						if($isex){
					?>
				<tr>
					<td valign="middle"><b>{{@$cure->name}} [{{@$cure->rate}}%]</b></td>
					<td id="tmp_total" valign="middle" style="width:110px;"><b>{{number_format($taxcal,$currencydata->decimal)}}</b></td>
				</tr>
				<?php } ?>
				@endif
          <tr>
            <td valign="middle"><b>Total</b></td>
            <td id="tmp_total" valign="middle" style="width:110px;"><b>{{$currencydata->currency_symbol}}{{number_format($finaltotal,$currencydata->decimal)}}</b></td>
          </tr>
		 
			@if($ispaymentexist)
				<?php $baldue = $finaltotal - $amount_rec; ?>
			<tr style="height:10px;">
				<td valign="middle">Payment Made</td>
				<td valign="middle" style="width:110px;color: red;">(-) {{number_format($amount_rec, $currencydata->decimal)}}</td>
			</tr>
			<tr style="height:10px;" class="inv-balance">
				<td valign="middle"><b>Balance Due</b></td>
				<td id="tmp_balance_due" valign="middle" style="width:110px;;"><strong>{{$currencydata->currency_symbol}}{{number_format($baldue, $currencydata->decimal)}}</strong></td>
			</tr>
			@endif
      <tr>
        <td style="border-bottom: 1px solid #9e9e9e;" colspan="2"></td>
      </tr>
        </tbody>
        <tbody>
          <tr>
            <td style="text-align: center;padding-top: 5px;" colspan="2">
                <div style="min-height: 75px;">
                  
                </div>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;border-bottom: 1px solid #9e9e9e;" colspan="2">
              <label style="margin-bottom: 0px;" class="pcs-totals">Authorized Signature</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="clear: both;"></div>
        
    <div style="clear: both;"></div>
  </div>
    
  </div>
 </div>
 </body>
</html>