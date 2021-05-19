<?php
/**
 * @OA\Get(path="/user/email_templates", tags={"x-user", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List email templates for user")
 * )
 */
Flight::route('GET /user/email_templates', function(){
  $account_id = Flight::get('user')['aid'];
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  $total = Flight::emailTemplateService()->get_email_templates($account_id, $offset, $limit, $search, $order, TRUE);
  header('total-records: ' . $total['total']);
  Flight::json(Flight::emailTemplateService()->get_email_templates($account_id, $offset, $limit, $search, $order));
});

/**
 * @OA\Get(path="/user/email_templates/{id}", tags={"x-user", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Id of email template"),
 *     @OA\Response(response="200", description="Fetch individual email template")
 * )
 */
Flight::route('GET /user/email_templates/@id', function($id){
  /*$template = Flight::emailTemplateService()->get_by_id($id);
  if ($template['account_id'] != Flight::get('user')['aid']){
    Flight::json([]);
  }else{
    Flight::json($template);
  }*/
  Flight::json(Flight::emailTemplateService()->get_email_template_by_account_and_id(Flight::get('user')['aid'], $id));
});

/**
 * @OA\Post(path="/user/email_templates", tags={"x-user", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic email template info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Name of the template" ),
 *    				 @OA\Property(property="subject", required="true", type="string", example="subject",	description="Subject of the email" ),
 *    				 @OA\Property(property="body", type="string", example="body",	description="Body of the email" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Saved email template")
 * )
 */
Flight::route('POST /user/email_templates', function(){
  Flight::json(Flight::emailTemplateService()->add_email_template(Flight::get('user'), Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/user/email_templates/{id}", tags={"x-user", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(type="integer", in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic emiail template info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Name of the template" ),
 *    				 @OA\Property(property="subject", required="true", type="string", example="subject",	description="Email Subject" ),
 *    				 @OA\Property(property="body", type="string", example="body",	description="Email body" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update email template")
 * )
 */
Flight::route('PUT /user/email_templates/@id', function($id){
  Flight::json(Flight::emailTemplateService()->update_email_template(Flight::get('user'), intval($id), Flight::request()->data->getData()));
});

/**
 * @OA\Get(path="/admin/email_templates", tags={"x-admin", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="account_id", default=0, description="Account ID"),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List email templates for user")
 * )
 */
Flight::route('GET /admin/email_templates', function(){
  $account_id = Flight::query('account_id');
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  Flight::json(Flight::emailTemplateService()->get_email_templates($account_id, $offset, $limit, $search, $order));
});

/**
 * @OA\Get(path="/admin/email_templates/{id}", tags={"x-admin", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Id of email template"),
 *     @OA\Response(response="200", description="Fetch individual email template")
 * )
 */
Flight::route('GET /admin/email_templates/@id', function($id){
  Flight::json(Flight::emailTemplateService()->get_by_id($id));
});

/**
 * @OA\Post(path="/admin/email_templates", tags={"x-admin", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic email template info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="account_id", required="true", type="integer", example=1,	description="Id of account"),
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Name of the template" ),
 *    				 @OA\Property(property="subject", required="true", type="string", example="subject",	description="Subject of the email" ),
 *    				 @OA\Property(property="body", type="string", example="body",	description="Body of the email" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Saved email template")
 * )
 */
Flight::route('POST /admin/email_templates', function(){
  Flight::json(Flight::emailTemplateService()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/admin/email_templates/{id}", tags={"x-admin", "email-templates"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(type="integer", in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic emiail template info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Name of the template" ),
 *    				 @OA\Property(property="subject", required="true", type="string", example="subject",	description="Email Subject" ),
 *    				 @OA\Property(property="body", type="string", example="body",	description="Email body" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update email template")
 * )
 */
Flight::route('PUT /admin/email_templates/@id', function($id){
  Flight::json(Flight::emailTemplateService()->update($id, Flight::request()->data->getData()));
});

?>
