importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyBKvL8VlM-OinidYvpP07YOXZgrsBIGAyU",
    authDomain: "alpine-inkwell-413112.firebaseapp.com",
    projectId: "alpine-inkwell-413112",
    storageBucket: "alpine-inkwell-413112.appspot.com",
    messagingSenderId: "704644944418",
    appId: "1:704644944418:web:16a522c6751d76d432f07b",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(title, options);
});
