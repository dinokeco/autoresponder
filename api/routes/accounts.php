<?php

Flight::route('GET /accounts', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 10);
  $search = Flight::query('search');
  
  Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit));
});

Flight::route('GET /accounts/@id', function($id){
  Flight::json(Flight::accountDao()->get_by_id($id));
});

Flight::route('POST /accounts', function(){
  $request = Flight::request()->data->getData();
  Flight::json(Flight::accountDao()->add($data));
});

Flight::route('PUT /accounts/@id', function($id){
  $request = Flight::request();
  $data = $request->data->getData();
  Flight::accountDao()->update($id, $data);
  $account = Flight::accountDao()->get_by_id($id);
  Flight::json($account);
});

?>
