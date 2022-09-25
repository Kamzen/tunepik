<template>
       
  <div class="app-right-side-view pt-4">

    <add-post></add-post>

    <div class="space-medium"></div>

    <Suggestions></Suggestions>

    <div class="space-small"></div>

    <chats-bottom-popper></chats-bottom-popper>

  </div>

</template>

<script>

  import AddPost from './AddPost'
  import Suggestions from './Suggestions'
  import ChatsBottomPopper from '../../builders/chatsBuilders/ChatsBottomPopper'

    export default {
      name: "RightSideBuilder",
      components : {
        AddPost,
        Suggestions,
        ChatsBottomPopper
      },
      computed : {
      },
        
    };
      
</script>

<style scoped>

    .app-right-side-view{

      position: fixed;
      right: 3%;
      top: 66px;
      bottom : 0;
      width : 28%;
      border-left: .04em solid rgba(211, 211, 211, .100);

    }

    

</style>