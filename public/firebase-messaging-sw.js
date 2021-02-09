
// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
importScripts('https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.10.1/firebase-messaging.js');
//importScripts('/__/firebase/init.js');

var config = {
    apiKey: "AIzaSyCZ6vWm7zngN3OqwclegBylD2s5a0-yxRE",
    authDomain: "dogcat-1526672577530.firebaseapp.com",
    databaseURL: "https://dogcat-1526672577530.firebaseio.com",
    projectId: "dogcat-1526672577530",
    storageBucket: "dogcat-1526672577530.appspot.com",
    messagingSenderId: "1035263249593"
};
firebase.initializeApp(config);
const messaging = firebase.messaging();

// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) {
    //console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    var cuerpo = payload.data.body;
    cuerpo = cuerpo.replace(/<[^>]*>?/g, '');

    var notificationTitle = payload.data.title;
    var notificationOptions = {
        body: cuerpo,
        icon: payload.data.icon,
        click_action: payload.data.click_action
    };

    self.addEventListener('notificationclick', function(event) {
        //console.log(event);
        event.notification.close();
        if(payload.data.click_action) {
            //window.location.href = payload.data.click_action;

            event.waitUntil(clients.matchAll({
                type: "window"
            }).then(function (clientList) {
                for (var i = 0; i < clientList.length; i++) {
                    var client = clientList[i];
                    if (client.url == '/' && 'focus' in client)
                        return client.focus();
                }
                if (clients.openWindow)
                    return clients.openWindow(payload.data.click_action);
            }));
        }
    });

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});

/** Here is is the code snippet to initialize Firebase Messaging in the Service
 * Worker when your app is not hosted on Firebase Hosting.

 // [START initialize_firebase_in_sw]
 // Give the service worker access to Firebase Messaging.
 // Note that you can only use Firebase Messaging here, other Firebase libraries
 // are not available in the service worker.

 importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');

 // Initialize the Firebase app in the service worker by passing in the
 // messagingSenderId.
 firebase.initializeApp({
   'messagingSenderId': 'YOUR-SENDER-ID'
 });

 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();
 // [END initialize_firebase_in_sw]



// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    var notificationTitle = 'Background Message Title';
    var notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
// [END background_handler]*/