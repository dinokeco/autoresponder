<?php

print_r($_ENV);
die;

class Config {
  const DATE_FORMAT = "Y-m-d H:i:s";

  const DB_HOST = "autoresponder-db-do-user-1249919-0.b.db.ondigitalocean.com";
  const DB_USERNAME = "autoresponder";
  const DB_PASSWORD = "autoresponder";
  const DB_SCHEME = "autoresponder";

  const SMTP_HOST = "smtp.mailgun.org";
  const SMTP_PORT = 587;
  const SMTP_USER = "postmaster@mail.shfy.io";
  const SMTP_PASSWORD = "";

  const JWT_SECRET = "y4KvQcZVqn3F7uxQvcFk";
  const JWT_TOKEN_TIME = 604800;
}

?>
