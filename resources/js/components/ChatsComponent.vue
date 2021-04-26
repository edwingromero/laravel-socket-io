<template>
  <div>
    <div class="row">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Messages</div>
          <div class="card-body p-1">
            <ul class="list-unstyled" style="height:300px;overflow-y:scroll" v-chat-scroll>
              <li v-for="(message,index) in messages" :key="index">
                <strong>{{ message.user.name }}</strong>:
                {{ message.message }}
              </li>
            </ul>
          </div>
          <input 
            @keydown="sendTypingEvent()"
            @keyup.enter="sendMessage()"
            v-model="newMessage"
            class="form-control"
            placeholder="Escribe tu mensaje..."          
            type="text">
          <span class="text-muted" v-if="activeUser">{{activeUser.name}} esta escribiendo</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-default">
          <div class="card-header">Active Users</div>
          <div class="card-body p-1">
            <ul>
              <li v-for="(user, index) in users" :key="index" class="py-2">
                {{user.name}}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:['user'],
  created() {
    let vue = this;
    this.fetchMessages();

    Echo.join('chat')
      .here( user => {
        vue.users = user;
      })
      .joining( user => {
        vue.users.push(user);
      })
      .leaving( user => {
        vue.users = vue.users.filter( u =>  u.id != user.id )
      })
      .listen('MessageSent', (event)=> {
        vue.messages.push(event.message);
        vue.activeUser = false;
      })
      .listenForWhisper('typing', user =>{
        vue.activeUser = user;

        if(vue.typingTimer){
          clearTimeout(vue.typingTimer)
        }

        vue.typingTimer = setTimeout(() => {
          vue.activeUser = false;
        }, 3000);
      })
  },
  data() {
    return {
      messages:[],
      newMessage:'',
      users:[],
      activeUser:false,
      typingTimer:false,
    }
  },

  methods: {
    fetchMessages(){
      let vue = this;
      axios.get('messages')
      .then(res => {
        vue.messages = res.data;
      })
    },
    sendMessage(){
      let vue = this;
      this.messages.push({
        user:vue.user,
        message:vue.newMessage
      });
      axios.post('message',{message:vue.newMessage})
      .then(res => {
        vue.newMessage = '';
      })
    },
    sendTypingEvent(){
      let vue = this;
      Echo.join('chat')
        .whisper('typing',vue.user)

    }
  },
}
</script>