function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path : '/', name: 'welcome', component: page('welcome.vue') },

  { path : '/login', name: 'login', component: page('auth/login.vue') },
  { path : '/login/face', name : 'selfie', component : page('auth/faceLogin.vue')},
  { path : '/register',
    component: page('auth/register/register.vue'),
    children : [
      { path : '', redirect : { name : 'register.username' } },
      { path : 'username', name : 'register.username', component : page('auth/register/username.vue') },
      { path : 'email', name : 'register.email', component : page('auth/register/email.vue') },
      { path : 'confirm', name : 'register.confirm', component : page('auth/register/confirm.vue') }
    ]
  },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }

    ]
  },

  /* NAV BARS */

  { path : '/home', name: 'home', component: page('home.vue') },
  { 
    path : '/messages',
    name : 'chats',
    component : page('convos/chats.vue'),
    children : [
      { path : '/messages/:username', name : 'messages', component : page('convos/messages.vue') },
    ]
  },
  { path : '/search', name : 'search', component : page('search.vue')},
  { path : '/notifications', name : 'notifications', component : page('notifications.vue')},
  { path : '/explore', name : 'explore', component : page('explore.vue') },
  { path : '/stories', name : 'gridstories', component : page('stories/gridstories.vue')},
  { path : '/stories/:username/:id', name : 'stories', component : page('stories/userstories.vue')},
  { path : '/create/post', name : 'createPost', component : page('create/createpost.vue')},
  { path : '/search/:term', name : 'results', component : page('bundle/results.vue') },
  /*{ path : '/report/:type', name : 'report', component : page('bundle/report.vue')},*/

  /* CAMERAA */

  { path : '/camera',
    name : 'camera',
    component : page('bundle/camera/maincamera.vue'),
    children : [

      { path : 'setup-face-id', name : 'camera.faceid', component : page('bundle/camera/faceid.vue') },
      { path : 'face-login', name : 'camera.facelogin', component : page('bundle/camera/facelogin.vue') }

    ]
  },

  /*  CREATE NEW STUFF */

  // { path : '/:username/:id/create/comment', name : 'createComment', component : page('create/comment.vue')},
  { path : '/p/:username/:type/:id', name : 'comment', component : page('comment/viewPost.vue') },
  { path : '/p/:username/:type/:id/comment', name : 'createcomment', component : page('create/createcomment.vue') },
  { path : '/p/:username/:type/:id/share', name : 'share', component : page('create/createshare.vue') },
  { path : '/s/:username/story', name : 'story', component : page('create/createstory.vue') },
  // { path : '/messages/:username', name : 'messages', component : page('convos/messages')},

  /* View Stuff */

  { path : '/p/:username/:id/list/:type', name : 'list', component : page('lists/userlists.vue') },

  { path : '/:username/edit',
    name : 'edit',
    component : page('profile/edit/edit.vue'),
    children  : [

        { path : 'account', name : 'edit.account', component : page('profile/edit/account.vue') },
        { path : 'blocked', name : 'edit.blocked', component : page('profile/edit/blocked.vue') },
        { path : 'password', name : 'edit.password', component : page('profile/edit/password.vue') },
        { path : 'display', name : 'edit.display', component : page('profile/edit/display.vue') },
        { path : 'report/:type', name : 'edit.report', component : page('bundle/report.vue') },

      ],

    },

  { path : '/:username',
    component : page('profile/profile.vue'),
    children  : [

        { path : '', redirect : { name : 'profile' } },
        { path : '/', name : 'profile', component : page('profile/list.vue') },
        { path : 'grid/:type', name : 'grid', component : page('profile/stats/grid.vue') },
        { path : 'liked', name : 'liked', component : page('profile/liked.vue') },
        { path : ':type', name : 'follows', component : page('profile/follows.vue')},

    ],

  },

  { path: '*', component: page('errors/404.vue') }
]
