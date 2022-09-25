<template>

	<div class="reg-wrapper">
		
		<form @submit.prevent="next()" @keydown="form.onKeydown($event)">
			
			<Navigation>
				 
				<div class="media-body ml-3">
					<span class="app-max-text">
						Choose Your Email
					</span>
				</div>
				<div class="media-right align-self-center">
					
					<span class="app-small-text">
						2 of 3
					</span>

				</div>

			</Navigation>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>

			<div class="form-group row">
	      <label class="col-md-3 col-form-label text-md-right">
	      	Email Address
	      </label>
	      <div class="col-md-7">
	        <input v-model="form.email" placeholder="email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
	        <has-error :form="form" field="email" />
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
	import axios from 'axios'

	export default {

		name 		: 'email',
		data 		: function(){
			return {
				mform : {},
			}
		},
		components : {
			Navigation
		},
		methods : {

			...mapMutations("auth", ['email']),
			next : function(){

				if(this.form.email === '') return

				this.email(this.form.email.toString().trim())

				this.$router.push({ name : 'register.confirm' })

			}

		},
		computed : {

			...mapGetters("auth", ['register']),
			form : function(){
				return new Form({
					email : this.register.email,
				})
			}

		},
		mounted : function(){

			this.$nextTick(function(){

				if(this.register.username === '') this.$router.push({ name : 'register.username' })

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