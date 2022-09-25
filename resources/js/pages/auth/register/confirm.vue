<template>

	<div class="reg-wrapper">
		
		<form @submit.prevent="register()" @keydown="form.onKeydown($event)">
			
			<Navigation>
				 
				<div class="media-body ml-3">
					<span class="app-max-text">
						Almost Done...
					</span>
				</div>
				<div class="media-right align-self-center">
					
					<span class="app-small-text">
						3 of 3
					</span>

				</div>

			</Navigation>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<!-- <div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div> -->
 
			<span class="app-small-text block-text m-1">Username</span>
			<span class="app-bolder-text block-text m-1">{{ register.username }}</span>

			<div class="space-small"></div>

			<span class="app-small-text block-text m-1">Email</span>
			<span class="app-bolder-text block-text m-1">{{ register.email }}</span>

			<hr />

			<span class="app-post-text">
				Secure Your Account With A Strong Password
			</span>

			<!-- Password -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">
        	Password
        </label>
        <div class="col-md-7">
          <input v-model="form.password" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
          <has-error :form="form" field="password" />
        </div>
      </div>

      <!-- Password Confirmation -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">
        	Confirm Password
        </label>
        <div class="col-md-7">
          <input v-model="form.password_confirmation" placeholder="Confirm password" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
          <has-error :form="form" field="password_confirmation" />
        </div>
      </div>

 		 	<div class="form-group row">
      <div class="col-md-7 offset-md-3 d-flex">
        <!-- Submit Button -->
        <v-button :loading="form.busy" :block="true" :type="'primary'">
          Next
        </v-button>
      </div>
    </div>

	</form>

		<div class="space-large"></div>
		<div class="space-large"></div>
		<div class="space-large"></div>
		<div class="space-large"></div>

	</div>
	
</template>

<script type="text/javascript">
	
	import Form from 'vform'
	import Navigation from '../../../components/mobile/root/Navigation'
	import { mapMutations, mapGetters } from 'vuex'

	export default {

		name 		: 'confirm',
		data 		: function(){
			return {
				mform : {},
				mustVerifyEmail: false
			}
		},
		components : {
			Navigation
		},
		methods : {

			...mapMutations("auth", ['password']),
			register : async function(){

				if(this.form.password === '' || this.form.password_confirmation === '') return

				this.password(this.form.password.toString().trim())

					// Register the user.
		      const { data } = await this.form.post('/api/register')

		      // Must verify email fist.
		      if (data.status) {
		        this.mustVerifyEmail = true
		      } else {
		        // Log in the user.
		        const { data: { token } } = await this.form.post('/api/login')

		        // Save the token.
		        this.$store.dispatch('auth/saveToken', { token })

		        // Update the user.
		        await this.$store.dispatch('auth/updateUser', { user: data })

		        // Redirect home.
		        this.$router.push({ name: 'home' })
		      }

			}

		},
		computed : {

			...mapGetters("auth", ['register']),
			form : function(){
				return new Form({
					password : this.register.password,
					password_confirmation : '',
					email : this.register.email,
					name 	: this.register.username
				})
			}

		},
		mounted : function(){

			this.$nextTick(function(){

				if(this.register.username === '') this.$router.push({ name : 'register.username' })
				else if(this.register.email === '') {
					this.$router.push({ name : 'register.email' })
				}

			})

		}

	};
	
</script>

<style type="text/css" scoped>
	
	@media only screen and (max-width: 700px){

		.reg-wrapper{

			width: 100%;
			height: 100%;
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 99999 !important;

		}

		.next-btn{
			position: relative;
			top: -4px;
		}

	}

	@media only screen and (min-width: 700px){}

</style>