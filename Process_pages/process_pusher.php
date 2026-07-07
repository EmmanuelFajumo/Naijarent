<?php
  require_once '../vendor/autoload.php';
  require_once 'classes/config.php';

  $options = array(
    'cluster' => PUSHER_APP_CLUSTER,
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    PUSHER_APP_KEY,
    PUSHER_APP_SECRET,
    PUSHER_APP_ID,
    $options
  );

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
  $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW) ?? '';

  $data = [
    'email' => $email,
    'password' => $password
  ];

  $pusher->trigger('my-channel', 'my-event', $data);
  header('location: ../pusher_test.php?inserted');
  exit;
?>