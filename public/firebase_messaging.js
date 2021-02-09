// Initialize Firebase
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
messaging.usePublicVapidKey('BJsscadxJPNT6cKYIsPPerHjjswXe3RfKJ3dJnIhBUQAXMW7wHXjk_FzeMrisHD0rLCOZbvKsDXPoxKuB-eglnU');
messaging.requestPermission().then(function() {
    console.log('Notification permission granted.');
    // TODO(developer): Retrieve an Instance ID token for use with FCM.
    // ...
    messaging.getToken().then(function(currentToken) {
        if (currentToken) {
            //console.log('OK',currentToken);
            messaging.onMessage(function(payload) {
                console.log('Message received. ', payload);
                var data = payload.data;
                var duracion = 30;
                if(data.tipo == 'recordatorio')
                    duracion = null;
                abrirNotificacionShow(data.title,data.body,data.icon,data.importancia,data.click_action,duracion,data.tipo);
                $('#modal-lista-notificaciones').find('#lista-notificaciones').prepend(data.html);
                notificaciones_cargadas.push(data.identificador_notificacion);
                //console.log(payload.);
                /*alert('msj alert');
                var notificationTitle = 'Background Message Title';
                var notificationOptions = {
                    body: 'Background Message body.',
                    icon: '/firebase-logo.png'
                };*/
            });
            updateTokenToServer(currentToken);
        } else {
            updateTokenToServer(false);
            // Show permission request.
            console.log('No Instance ID token available. Request permission to generate one.');
            // Show permission UI.
            //updateUIForPushPermissionRequired();
            //setTokenSentToServer(false);
        }
    }).catch(function(err) {
        updateTokenToServer(false);
        console.log('An error occurred while retrieving token. ', err);
        //showToken('Error retrieving Instance ID token. ', err);
        //setTokenSentToServer(false);
    });
}).catch(function(err) {
    console.log('Unable to get permission to notify.', err);
    updateTokenToServer(false,false);
});

messaging.onTokenRefresh(function() {
    messaging.getToken().then(function(refreshedToken) {
        console.log('Token refreshed.');
        // Indicate that the new Instance ID token has not yet been sent to the
        // app server.
        updateTokenToServer(refreshedToken);
    }).catch(function(err) {
        updateTokenToServer(false);
        console.log('Unable to retrieve refreshed token ', err);
        //showToken('Unable to retrieve refreshed token ', err);
    });
});

function updateTokenToServer(currentToken,permitirNotificaciones = true){
    if(!permitirNotificaciones){
        var params = {_token: $('#general_token').val(), permitir_notificaciones:'no'};
    }else {
        if (currentToken)
            var params = {_token: $('#general_token').val(), token: currentToken, permitir_notificaciones:'si'};
        else
            var params = {_token: $('#general_token').val(), permitir_notificaciones:'si'};
    }

    var url = $('#general_url').val()+'/firebase/actualizar-token-registro';
    $.post(url,params);
}
