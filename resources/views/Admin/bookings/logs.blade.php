<h2>Onward Response</h3>
<main>
<?php
echo '<pre>';
print_r(json_decode($fetchedData->booking_response));
echo '<pre>';
?>
</main>
@if($fetchedData->booking_response_ib)
<h2>Return Response</h3>
<main>
<?php
echo '<pre>';
print_r(json_decode($fetchedData->booking_response_ib));
echo '<pre>';
?>
</main>
@endif