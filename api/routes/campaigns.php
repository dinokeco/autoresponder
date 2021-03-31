<?php
/**
 * @OA\Get(path="/user/campaigns", tags={"x-user", "campaigns"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="string", in="query", name="status", default="ACTIVE", description="Status of campaign"),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List campaigns for user")
 * )
 */
Flight::route('GET /user/campaigns', function(){
  $account_id = Flight::get('user')['aid'];
  $status = Flight::query('status', 'ACTIVE');
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  Flight::json(Flight::campaignService()->get_campaigns($account_id, $status, $offset, $limit, $search, $order));
});

/**
 * @OA\Get(path="/user/campaigns/{id}", tags={"x-user", "campaigns"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="id of the campaign"),
 *     @OA\Response(response="200", description="Fetch individual campaign")
 * )
 */
Flight::route('GET /user/campaigns/@id', function($id){
  $campaign = Flight::campaignService()->get_by_id($id);
  if ($campaign['account_id'] != Flight::get('user')['aid']){
    throw new Exception("Invalid campaign", 403);
  }else{
    Flight::json($campaign);
  }
});

/**
 * @OA\Post(path="/user/campaigns", tags={"x-user", "campaigns"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic campaigns info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Name of the campaign" ),
 *    				 @OA\Property(property="start_date", required="true", type="string", example="2021-03-31",	description="Start date of campaign" ),
 *    				 @OA\Property(property="end_date", type="string", example="2022-03-31",	description="End date of campaign" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Saved campaign")
 * )
 */
Flight::route('POST /user/campaigns', function(){
  Flight::json(Flight::campaignService()->add_campaign(Flight::get('user'), Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/user/campaigns/{id}", tags={"x-user", "campaigns"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(type="integer", in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic campaigns info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Name of the campaign" ),
 *    				 @OA\Property(property="status", required="true", type="string", example="ACTIVE",	description="Status [ACTIVE, PAUSED, DELETED]" ),
 *    				 @OA\Property(property="start_date", required="true", type="string", example="2021-03-31",	description="Start date" ),
 *    				 @OA\Property(property="end_date", type="string", example="2022-03-31",	description="End date" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Updated campaign")
 * )
 */
Flight::route('PUT /user/campaigns/@id', function($id){
  Flight::json(Flight::campaignService()->update_campaign(Flight::get('user'), $id, Flight::request()->data->getData()));
});

?>
