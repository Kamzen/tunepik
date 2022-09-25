import jQuery from 'jquery'
import globs from '../../tunepik/attack.js'

jQuery.noConflict();


export const state = {

	theme 		: {

		type  : localStorage.getItem('theme-color') === null ? 'theme-light' : localStorage.getItem('theme-color'),  // default, darkcity, light
		icons  : {
			type : localStorage.getItem('icon-color') === null ? 'default' : localStorage.getItem('icon-color'),
			color : ''
		},
		colors : {

			dark 			: '#222',
			dim 			: '#343a40',
			light 		: '#fff',
			white     : '#fff',
			blue  		: '#5bc0de',
			red 			: 'red',
			lightgrey : '#f5f8fa', // 6c757d f5f8fa
			darkgrey  : '#343a40', // 343a40 e1e83d
			grey 			: 'rgba(211, 211, 211, .4)',
			yellow    : '#ffc107',
			orange    : '#fd7e14',
			green     : '#28a745',
			greymatter: 'rgba(211, 211, 211, .100)',
			primary   : ['#fd7e14', '#ffc107', '#28a745', '#5bc0de']

		},
		themes : {

			primary : '#5bc0de', // #FFFC00
			secondary : '#63dbff',
			tertiary : null,

		},

	},
	overlay : {

		popup 		: {
			isOpen : false,
		},

		snackbar	: {
			isOpen : false,
			theme   : 'info',
			message : ''
		},

		confirm 	: {
			isOpen : false,
		}

	},  // #111, blue
	button : {
		 /*type : localStorage.getItem('button-type') === null ? 'button-circle' : localStorage.getItem('button-type'),*/
		 range : localStorage.getItem('button-range') === null ? 20 : Number(localStorage.getItem('button-range'))
	},
	columns : {
		one : 'col-lg-8',
		two : 'col-lg-4'
	}

}

export const getters = {

	theme  		: state => state.theme,
	overlay		: state => state.overlay,
	button 		: state => state.button,
	columns 	: state => state.columns

}

export const mutations = {

	SET_THEME : function(state, theme){

		state.theme.type = theme.type

		state.theme.icons.color = theme.icon

		state.theme.icons.type = theme.icontype ? theme.icontype : state.theme.icons.type

	},
	SNACK_BAR : function(state, data){

		state.overlay.snackbar.isOpen = data.isOpen

		if(state.overlay.snackbar.isOpen){

			state.overlay.snackbar.message = data.message
			state.overlay.snackbar.theme = data.theme ? data.theme : 'info'

			setTimeout(() => {

				state.overlay.snackbar.isOpen = false
				state.overlay.snackbar.message = ''

			}, 5500)

		}

	},
	POP_UP 		: function(state, isOpen){

		state.overlay.popup.isOpen = isOpen

	},
	COMFIRM 	: function(state, isOpen){

		state.overlay.confirm.isOpen = isOpen

	},
	SET_BUTTON_STYLE : function(state, button){

		localStorage.setItem('button-range', button.range)
		state.button.range = button.range

	},
	SET_COLUMNS : function(state, columns){

		state.columns.one = columns.one || 'col-lg-8'
		state.columns.two = columns.two || 'col-lg-4'

	}

}

export const actions = {

	changeManifest : function({ commit, state, dispatch }, color){

		let manifest = {

			"name" : "TunePik",
			"orientation"	: "portrait",
			"start_url"  	: globs.url,
			"display"			: "standalone",
			"theme_color"	: color,
			"background_color": color,

		}

		let url = URL.createObjectURL((new Blob([JSON.stringify(manifest)], {type : 'application/json'})))
		document.querySelector("#app-manifest").setAttribute('href', url)
		document.querySelector("#app-theme-color").setAttribute("content", color)

	},
	getIconColor : function({ state }){
		return state.theme.icons.type === 'default' ? state.theme.colors.blue : state.theme.icons.color
	},
	getTextColor : function({ state }){
		return state.theme.type === 'theme-dark' || state.theme.type === 'theme-dim' ? (state.theme.icons.type === 'default' ? state.theme.colors.light : state.theme.colors.lightgrey) : state.theme.colors.darkgrey
	},
	toggleTheme : function({ commit, state, dispatch }, type){

			if(state.theme.type == type) return

			if(localStorage.getItem('theme-color')){
				localStorage.removeItem('theme-color')
				localStorage.setItem('theme-color', type)
			}else{
				localStorage.setItem('theme-color', type)
			}

			let iconColor = null
			let isMobile = screen.width < 700 

			switch (type) {

				case 'theme-light'    :

						iconColor = state.theme.icons.type == 'default' ? state.theme.colors.dark : state.theme.icons.color
						document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.light 
						dispatch('changeManifest', state.theme.colors.light)

					break;

				case 'theme-dark' :

						iconColor = state.theme.icons.type == 'default' ? state.theme.colors.light : state.theme.icons.color
						document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.dark 
						dispatch('changeManifest', state.theme.colors.dark)

						break;

				case 'theme-dim'	:

						iconColor = state.theme.icons.type == 'default' ? state.theme.colors.light : state.theme.icons.color
						document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.dim 
						dispatch('changeManifest', state.theme.colors.dim)

					break;

				default:

						iconColor = '#5bc0de'

					break;
			}

			commit('SET_THEME', {

				type 		: type,
				icon    : iconColor,

			});
	},
	backgroundColor : function({ state, dispatch }){

		dispatch('toggleColors', state.theme.icons.type)

		let isMobile = screen.width < 700 

		switch (state.theme.type) {

			case 'theme-light'	:

					document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.light 
					dispatch('changeManifest', state.theme.colors.light)

				break;

			case 'theme-dark'		:

					document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.dark 
					dispatch('changeManifest', state.theme.colors.dark)

				break;

			case 'theme-dim'	   :

					document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.dim 
					dispatch('changeManifest', state.theme.colors.dim)

				break;

			default:

					document.querySelector("#main-body").style.backgroundColor =  state.theme.colors.light 
					dispatch('changeManifest', state.theme.colors.light)

				break;
		}

	},
	toggleColors     : function({ state, commit }, type){

			if(localStorage.getItem('icon-color')){
				localStorage.removeItem('icon-color')
				localStorage.setItem('icon-color', type)
			}else{
				localStorage.setItem('icon-color', type)
			}

		switch (type) {

			case 'first' 	:

					commit('SET_THEME',{

						type : state.theme.type,
						icon : state.theme.colors.primary[0],
						icontype : type

					})

				break;

			case 'second' :

					commit('SET_THEME',{

						type : state.theme.type,
						icon : state.theme.colors.primary[1],
						icontype : type

					})

			  break;

			case 'third'  :

					commit('SET_THEME', {

						type : state.theme.type,
						icon : state.theme.colors.primary[2],
						icontype : type

					})

			  break;

			default:

					commit('SET_THEME', {

						type : state.theme.type,
						icon : state.theme.type == 'theme-dark' || state.theme.type == 'theme-dim' ? state.theme.colors.light : state.theme.colors.dark,
						icontype : 'default'

					})

				break;
		}

	},
	toggleSnackBar : function({ state, commit }, data = null){

		if(data){

		}

	},
	togglePopUp 	 : function({ state, commit }){
			commit('POP_UP', state.overlay.popup.isOpen ? false : true)
	},
	toggleConfirm  : function({ state, commit }){
		commit('CONFIRM', state.overlay.confirm.isOpen ? false : true)
	},

	isVisible 			: function(_, args){

   	  let pageTop = jQuery(window).scrollTop();
      let pageBottom = pageTop + jQuery(window).height();
      let elementTop = jQuery(args.element).offset().top;
      let elementBottom = elementTop + jQuery(args.element).height();

      args.callback(args.inView ? ((pageTop < elementTop) && (pageBottom > elementBottom)) : ((elementTop <= pageBottom) && (elementBottom >= pageTop)));
      // isVisible
   },

   scroller   		: function({ dispatch }, args){

   		window.addEventListener('scroll', () => {
   			dispatch('isVisible', args)
   		})

   },

   observer 	: function(_, args){

   	console.log(args)
   	console.log(args.callback)
   	const Observer = new IntersectionObserver(args.callback, args.options, )
   	Observer.observe(args.target)

   }

}
