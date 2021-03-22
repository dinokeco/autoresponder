<?php
/* Swagger documentation */
/**
 * @OA\Info(title="Autoresponder API", version="0.1")
 * @OA\OpenApi(
 *    @OA\Server(url="http://localhost/autoresponder/api/", description="Development Environment" ),
 *    @OA\Server(url="https://autoresponder.biznet.ba/api/", description="Production Environment" )
 * )
 */


/**
 * @OA\Get(path="/accounts",
 *     @OA\Response(response="200", description="List accounts from database")
 * )
 */
Flight::route('GET /accounts', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/accounts/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="List accounts from database")
 * )
 */
Flight::route('GET /accounts/@id', function($id){
  Flight::json(Flight::accountService()->get_by_id($id));
});

/**
 * @OA\Post(path="/accounts",
 *     @OA\Response(response="200", description="Add account")
 * )
 */
Flight::route('POST /accounts', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::accountService()->add($data));
});

/**
 * @OA\Put(path="/accounts/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update account based on id")
 * )
 */
Flight::route('PUT /accounts/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::accountService()->update($id, $data));
});

?>
