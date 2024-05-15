importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyDCqkj6J7KAzit1n9lSFj-9_2vTVFzrS74",
    projectId: "fds-demo-a8327",
    messagingSenderId: "398626906585",
    appId: "1:398626906585:web:6890d250e9cb31c75cb9c8",
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    console.log('Message Received : ' + data);
    return self.registration.showNotification(title,{body,icon});
});