    
const ZoomVideo = window.WebVideoSDK.default

const context = {
    topic: 'random0000x1',
    username: 'admin@xmattv.com',
    //password: 'Password1!',
    jwt: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBfa2V5IjoiSk8wQ21rLXdSQUNZV2JZZVZfd192QSIsInJvbGVfdHlwZSI6MSwidHBjIjoicmFuZG9tMDAwMHgxIiwidmVyc2lvbiI6MSwiaWF0IjoxNzEwMjgwMzE1LCJleHAiOjE3MTAyODM5MTV9.J1FNhfGCX_9QUvZDb49_UcWuV2kMXxm9RS-Zr7Ow2oY'
};

var client = ZoomVideo.createClient()
var stream

client.init('en-US', 'Global', { patchJsMedia: true }).then( () => {
    client.join(context.topic, context.jwt, context.username).then( () => {
        stream = client.getMediaStream()
    });
});

client.on('user-added', (payload) => {
    console.log(payload[0].userId + ' joined the session')
})

client.on('user-removed', (payload) => {
    console.log(payload[0].userId + ' left the session')
})

client.on('user-updated', (payload) => {
    console.log(payload[0].userId + ' properties were updated')
})

client.on('connection-change', (payload) => {
    if(payload.state === 'Closed') {
        // session ended by the host or the SDK kicked the user from the session (use payload.reason to see why the SDK kicked the user)
    } else if(payload.state === 'Reconnecting') {
        // the client side has lost connection with the server (like when driving through a tunnel)
        // will try to reconnect for a few minutes
    } else if(payload.state === 'Connected') {
        // SDK reconnected the session after a reconnecting state
    } else if(payload.state === 'Fail') {
        // session failed to reconnect after a few minutes
        // user flushed from Zoom Video SDK session
    }
})


stream.startVideo({ virtualBackground: { imageUrl: './sw1.jpg' } }).then(() => {
    stream.attachVideo(stream.getCurrentUserInfo().userId, RESOLUTION).then((userVideo) => {
      document.querySelector('video-player-container').appendChild(userVideo)
    })
  })


if (stream.isRenderSelfViewWithVideoElement()) {
stream
    .startVideo({ videoElement: document.querySelector('#my-self-view-video') })
    .then(() => {
    // video successfully started and rendered
    })
    .catch((error) => {
    console.log(error)
    })
} else {
stream
    .startVideo()
    .then(() => {
    stream
        .renderVideo(
        document.querySelector('#my-self-view-canvas'),
        client.getCurrentUserInfo().userId, 1920, 1080, 0, 0, 3)
        .then(() => {
        // video successfully started and rendered
        })
        .catch((error) => {
        console.log(error)
        })
    })
    .catch((error) => {
    console.log(error)
    })
}
  