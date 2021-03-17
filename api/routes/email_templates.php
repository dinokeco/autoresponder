<?php

Flight::route('POST /email_templates', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::emailTemplateService()->add($data));
});


?>
