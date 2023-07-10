<?php $set = \App\Admin::where('id',1)->first(); ?>
Dear Customer,<br>
This is in regard to your Holiday Planner Reference {{@$set->ref_prefix}}{{@$fetchedData->id}}. Your booking is all confirmed. Please find the E-Ticket PDF Document attached here with. 
<br>
<br>

DO NOT REPLY TO THIS EMAIL. Emails to this email address are not monitored. You may write to us at {{@$set->b2c_email}} or call us on {{@$set->phone}} to resolve your query, if any.
Regards,
Holiday Planner Helpdesk