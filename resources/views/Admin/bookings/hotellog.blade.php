<h2>Booking Request</h3>
<main>
<?php
echo '<pre>';
print_r(json_decode($fetchedData->booking_request));
echo '<pre>';
?>
</main>


<h2>Booking Response</h3>
<main>
<?php
echo '<pre>';
print_r(json_decode($fetchedData->booking_response));
echo '<pre>';
?>
</main>