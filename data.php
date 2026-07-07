<?php
require_once 'config.php';
$propertyId = isset($_GET['property_id']) ? (int)$_GET['property_id'] : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Chat Demo</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Property chat demo</h4>
                    </div>
                    <div class="card-body">
                        <div id="messages" class="border rounded p-3 mb-3" style="min-height: 220px; max-height: 320px; overflow-y: auto;"></div>
                        <form id="chatForm" method>
                            <input type="hidden" name="property_id" value="<?php echo $propertyId; ?>">
                            <div class="input-group">
                                <input type="text" id="message" name="message" class="form-control" placeholder="Type your message" required>
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                        </form>
                        <div id="status" class="small text-muted mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('844bdf4c4a34fd7dc916', {
        cluster: 'mt1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
        alert(JSON.stringify(data));
        });
    </script>
</body>
</html>