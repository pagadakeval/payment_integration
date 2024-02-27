<html>
    <!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('3587e9d9555c01d6a9dd', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>
     Pusher.logToConsole = true;
    var pusher = new Pusher('3587e9d9555c01d6a9dd', {
      cluster: 'ap2'
    });
    var channel = pusher.subscribe('my-channel');
    channel.bind('form-submitted', function(data) {
      if (data && data.post && data.post.name && data.post.description) {
        toastr.success('New Post Created', 'Author: ' + data.post.name + '<br>Title: ' + data.post.description, {
          timeOut: 0,  
          extendedTimeOut: 0,  
        });
      } else {
        console.error('Invalid data structure received:', data);
      }
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
</html>