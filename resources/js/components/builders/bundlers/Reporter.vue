<template>

  <div class="report-wrapper">

    <div class="card no-border">

      <div class="card-header no-border">

        <PostSnippet :post="reporter.reportObj" v-if="reporter.type === 'post'"></PostSnippet>

        <ProfileSnippet :user="reporter.reportObj" v-if="reporter.type === 'user'"></ProfileSnippet>

      </div>
      <div class="card-body no-border">

        <span class="app-small-text" v-if="response.error" style="color : red">
          {{ response.message }}
        </span>

        <form @submit.prevent="submitReport">

          <div class="form-group">
            <textarea placeholder="Write Your Report" v-model="form.report_text" class="form-control"></textarea>
            <input type="hidden" v-model="form.type" />
          </div>
          <div class="form-group">
            <v-button :block="true" :type="'primary'" :loading="form.busy">
              Submit Report
            </v-button>
          </div>

        </form>

      </div>


    </div>
    
  </div>

</template>

<script>

    import { mapGetters, mapMutations } from 'vuex'
    import PostSnippet from "../snippets/PostSnippet"
    import ProfileSnippet from "../snippets/ProfileSnippet";
    import Form from 'vform'

    export default {
        name: "Reporter",
        data : () => ({
          form : new Form({
            report_text : '',
            type : ''
          }),
          response : {
            error : false,
            message : ''
          }
        }),
        components: {
          PostSnippet,
          ProfileSnippet
        },
        methods : {
          ...mapMutations('report', ['SET_REPORT']),
          ...mapMutations('tunepik', ['SNACK_BAR']),
          id (){
            return this.reporter.type === 'post' ? this.reporter.reportObj.getPost().id : this.reporter.reportObj.getBasic().id

            switch (this.reporter.type) {
              case 'post':
                return this.reporter.reportObj.getPost().id
                break;
              case 'comment':
                return this.reporter.reportObj.getPost().id
                break;
              case 'user':
                return this.reporter.reportObj.getBasic().id
                break;
              case 'bug':
                return 0
                break;
              default:
                return 0
                break;
            }
          },
          async submitReport (){

            const { data } = await this.form.post(`/api/report/${this.reporter.type}/${this.id}`)

            if(data.error){

              this.response.error = data.error
              this.response.message = data.message

            }else{

              this.SNACK_BAR({ isOpen : true, message : data.message, theme : 'info' })
              this.SET_REPORT(null, '')

              if(this.reporter.type === 'post' || this.reporter.type === 'comment'){

                this.$router.push( { name : 'comment',
                  params: {
                    username : this.reporter.reportObj.getBasic().handle,
                    type     : this.reporter.reportObj.getPost().type,
                    id       : this.reporter.reportObj.getPost().id
                  }
                })

              }else if(this.reporter.type == 'user'){

                this.$router.push( { name : 'profile', params: { username : this.reporter.reportObj.getBasic().handle } })

              }

            }

          }
        },
        computed : {
          ...mapGetters('report', ['reporter']),
        }
    };
</script>

<style scoped>

</style>
