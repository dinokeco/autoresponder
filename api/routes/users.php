<?php

/**
 * @OA\Post(path="/users/register", tags={"users"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="account", required="true", type="string", example="My Test Account",	description="Name of the account" ),
 *     				 @OA\Property(property="name", required="true", type="string", example="First Last Name",	description="Name of the user`" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->register($data);
  Flight::json(["message" => "Confirmation email has been sent. Please confirm your account"]);
});

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userService()->confirm($token);
  Flight::json(["message" => "Your account has been activated"]);
});

/**
 * @OA\Post(path="/users/login", tags={"users"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /users/login', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->login($data));
});
