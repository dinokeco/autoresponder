<?php
/**
 * @OA\Post(path="/admin/cdn", tags={"x-admin", "cdn"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Upload file to CDN", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="FileName" ),
 *    				 @OA\Property(property="content", required="true", type="string", example="test",	description="Base64 encoded content" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Upload file to CDN")
 * )
 */
Flight::route('POST /admin/cdn', function(){
  $data = Flight::request()->data->getData();
  $url = Flight::cdnClient()->upload($data['name'], $data['content']);
  Flight::json(["url" => $url]);
});
