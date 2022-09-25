<template>

		<div class="wrapper">

			<v-button :type="'danger'" :loading="block.loading" :block="true"  @click.native="toggleBlock()">
					
					{{ user.getActivity().youBlock ? 'Unblock' : 'Block' }}

			</v-button>



			<div class="overlay-wrap" v-show="show">
        
        <div class="main-wrap card no-border" v-show="show" :class="[ show ? 'fade-in' : 'fade-out']">
          
          <div class="media card-header no-border">

            <div class="media-left align-self-center">
              
              <Picture :width="35" :height="35" :user="user"></Picture>

            </div>
            
            <div class="media-body align-self-center pl-3">
              
              <span class="app-max-text">
                Block
              </span>
              <span class="block-text app-grey-text-lg">(@{{ user.getBasic().handle }})</span>

            </div>
            <div class="media-right align-self-center">
              
              <a @click="show = !show">
                
                <i class="fa fa-times app-fa"></i>

              </a>

            </div>

          </div>
          <div class="card-body no-border">
            
            <div class="list-group">
          
              <div class="list-group-item">
                <center>
                  <span class="app-grey-text-lg">
                    Are You Sure You Want To Unblock
                    <span class="app-bolder-text">
                    @{{ user.getBasic().handle }}?
                  </span>
                  </span>
                </center>
              </div>
              <div class="list-group-item">
                
                <v-button :loading="block.loading" @click.native="blocker()" :type="'primary'" class="mobile-share-control-btn yes">
        
                  Unblock

                </v-button>
                <v-button @click="show = !show" :type="'danger'" class="mobile-share-control-btn no">
                  Cancel
                </v-button>

              </div>

            </div>

          </div>

        </div>

      </div>

		</div>
	
</template>

<script type="text/javascript">

		import axios from 'axios'
		import PopUpWindow from '../popupBuilders/PopUpWindow'

		export default {

			name  			: "BlockButton",
			components  : {

				PopUpWindow

			},
			data 				: () => ({

			  success : 'btn-danger',
			  danger  : 'btn-danger',
			  show    : false,
				block : {
						loading : false,
						message : '',
						error   : false,
				}

			}),
			props    : ['user', 'classes'],
			methods  : {

				blocker  : async function(){

						this.block.loading = true

						const { data } = await axios.get(`/api/react/block/${this.user.getBasic().id}`);

						this.block.error = data.error;
						this.block.message = data.message;

						this.user.getActivity().youBlock = data.blocked;
						this.user.getActivity().blocked = data.blocked

						this.block.loading = false;

				},
				toggleBlock : function(){
					if(this.user.getActivity().youBlock){
						this.show = !this.show
					}else{
						this.blocker()
					}
				}

			},
			computed : {

				header : function(){

					return `Unblock @${this.user.getBasic().handle}`;

				}

			},
			created : function(){
			}

		};
	
</script>

<style type="text/css" scoped>

  .list-group-item{

  	border: 0;

  }
	
</style>