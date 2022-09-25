function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
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
    ] },

  /* NAV BARS */

  { path : '/home', name: 'home', component: page('home.vue') },
/*  { path : '/messages', name : 'chats', component : page('convos/chats.vue')},*/
  { path : '/search', name : 'search', component : page('search.vue')},
  { path : '/notifications', name : 'notifications', component : page('notifications.vue')},
  { path : '/create/post', name : 'createPost', component : page('create/createpost.vue')},

  /*  CREATE NEW STUFF */

  // { path : '/:username/:id/create/comment', name : 'createComment', component : page('create/comment.vue')},
  { path : '/:username/:type/:id', name : 'comment', component : page('comment/viewPost.vue')},
  // { path : '/messages/:username', name : 'messages', component : page('convos/messages')},

  /* View Stuff */

  { path : '/:username/:id/list/:type', name : 'list', component : page('lists/userlists.vue')},

  { path : '/:username',
    component : page('profile/profile.vue'),
    children  : [

        { path : '', redirect : { name : 'profile' } },

        { path : '/', name : 'profile', component : page('profile/list.vue') },

        { path : 'grid', name : 'grid', component : page('profile/grid.vue') },

        { path : 'liked', name : 'liked', component : page('profile/liked.vue') },

        { path : ':type', name : 'follows', component : page('profile/follows.vue')}

    ]
  
  },

  { path: '*', component: page('errors/404.vue') }
]
