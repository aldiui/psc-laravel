<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<script>
    const firebaseConfig = {
        apiKey: "AIzaSyBKvL8VlM-OinidYvpP07YOXZgrsBIGAyU",
        authDomain: "alpine-inkwell-413112.firebaseapp.com",
        projectId: "alpine-inkwell-413112",
        storageBucket: "alpine-inkwell-413112.appspot.com",
        messagingSenderId: "704644944418",
        appId: "1:704644944418:web:16a522c6751d76d432f07b"
    };

    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    function startFCMToken() {
        messaging.requestPermission().then(function() {
            return messaging.getToken()
        }).then(function(token) {
            $.ajax({
                url: "{{ route('fcm-token') }}",
                type: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                },
                data: {
                    _method: "PUT",
                    token: token
                },
                success: function(data) {
                    console.log("Token saved successfully");
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });


        }).catch(function(err) {
            console.log(`Token Error :: ${err}`);
        });
    }

    startFCMToken()

    messaging.onMessage(function(payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
