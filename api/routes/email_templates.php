<?php

Flight::route('GET /email_templates', function(){
  $account_id = Flight::query('account_id');
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  Flight::json(Flight::emailTemplateService()->get_email_templates($account_id, $offset, $limit, $search, $order));
});

Flight::route('POST /email_templates', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::emailTemplateService()->add($data));
});


?>
