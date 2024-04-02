<?php
require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

$js = <<<EOF
<script>

window.addEventListener("DOMContentLoaded", async event => {
  checkRegistration();
  
  document.getElementById("register").addEventListener("click", register);
  document.getElementById("unregister").addEventListener("click", unregister);
  
});
///opt/bitnami/letsencrypt/certificates 
// Check a service worker registration status
async function checkRegistration() {
  if ('serviceWorker' in navigator) {
      const registration = await navigator.serviceWorker.getRegistration();
      if (registration) {
        document.getElementById("output").innerHTML += "<br/>Service worker was registered on page load"
      } else {
        document.getElementById("output").innerHTML += "<br/>No service worker is currently registered"
      }
  } else {
    document.getElementById("output").innerHTML += "<br/>Service workers API not available";
  }
}

// Registers a service worker
async function register() {
  if ('serviceWorker' in navigator) {
    try {
      // Change the service worker URL to see what happens when the SW doesn't exist
      const registration = await navigator.serviceWorker.register("./serviceworker.js");
      document.getElementById("output").innerHTML += "<br/>Service worker registered";
       
    } catch (error) {
      document.getElementById("output").innerHTML += "<br/>Error while registering: " + error.message;
    }    
  } else {
    document.getElementById("output").innerHTML += "<br/>Service workers API not available";
  }
}; 

// Unregister a currently registered service worker
async function unregister()  {
  if ('serviceWorker' in navigator) {
    try {
      const registration = await navigator.serviceWorker.getRegistration();
      if (registration) {
        const result = await registration.unregister();
        document.getElementById("output").innerHTML += result ? "<br/>Service worker unregistered" : "<br/>Service worker couldn't be unregistered";
      } else {
        document.getElementById("output").innerHTML += "<br/>There is no service worker to unregister";
      }     
    } catch (error) {
      document.getElementById("output").innerHTML +="Error while unregistering: " + error.message;
    }    
  } else {
    document.getElementById("output").innerHTML += "<br/>Service workers API not available";
  }
};

</script>
<div id="output"></div>
<div>
<button id="register" type="button" >Register</button>
<button id="unregister" type="button" >Unregister</button>
</div>
EOF;

echo $pagegen->contentWrap(fn() => $js);

?>