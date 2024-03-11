importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyBKvL8VlM-OinidYvpP07YOXZgrsBIGAyU",
    projectId: "alpine-inkwell-413112",
    messagingSenderId: "704644944418",
    appId: "1:704644944418:web:16a522c6751d76d432f07b",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function ({
    data: { title, body, icon },
}) {
    return self.registration.showNotification(title, { body, icon });
});
