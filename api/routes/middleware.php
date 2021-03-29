<?php

Flight::before('start', function(&$params, &$output){

  if (Flight::request()->url == '/swagger') return TRUE;

  if (str_starts_with(Flight::request()->url, '/users/')) return TRUE;

  $headers = getallheaders();
  $token = @$headers['Authentication'];
  try {
    $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", ["HS256"]);
    Flight::set('user', $decoded);
    // ADMIN - create set of routes /admin/something
    // USER - set of routes for regular users
    // USER_READ_ONLY - block POST and PUT methods
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

?>
