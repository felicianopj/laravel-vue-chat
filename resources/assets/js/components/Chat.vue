<template>
	<div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>
            <div v-for="user in userList" @click="chooseUser(user)" class="panel-body user-list">
                <a class="user-link">{{ user.name }}</a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
      <div class="panel panel-default">
         <div class="panel-heading">Chat with {{ user.name }}</div>
         <div class="panel-body">
            <p v-for="message in messages">{{ message.content }}</p>
            <form action="" method="POST" @submit.prevent="sendMessage">
                <div class="row">
                    <div class="col-lg-9">
                    <input v-model="newMessage" type="text" name="content" class="form-control" placeholder="Type your message" autofocus>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary form-control send-button">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
    export default {
    	data: function () {
    		return {
                userList: [],
                user: { id: '', name: '' },
                authUser: { id: '', name: '' },
                newMessage: '',
                messages: {
                    sender_id: '',
                    receiver_id: '',
                    content: '',
                    created_at: '',
                },
            }
        },
        ready: function () {
            this.fetchUsers()
        },
        methods: {
            fetchUsers: function () {
                this.$http.get('api/users').then(function (response) {
                    this.userList = response.data
                    this.user = response.data[0]
                    this.fetchAuthUser()
                    this.fetchMessages()
                });
            },
            fetchAuthUser: function () {
                this.$http.get('api/auth-user').then(function (response) {
                    this.authUser = response.data
                });
            },
            fetchMessages: function () {
                this.$http.get('api/messages/' + this.user.id).then(function (response) {
                    this.messages = response.data
                    this.assignMessages()
                });
            },
            chooseUser: function (user) {
                this.user = user
                this.fetchMessages()
            },
            assignMessages: function () {
                for (var i = 0; i <= this.messages.length; i++) {
                    if (this.messages[i].sender_id == this.authUser.id) {
                        this.messages[i].content = this.authUser.name + ' says: ' + this.messages[i].content
                    }
                    else if (this.messages[i].receiver_id == this.authUser.id) {
                        this.messages[i].content = this.user.name + ' says: ' + this.messages[i].content
                    }
                }
            },
            sendMessage: function () {
                this.$http.post('api/message', {'id': this.user.id, 'content': this.newMessage}).then(function (response) {
                    this.newMessage = ''
                    this.fetchMessages()
                });
            }
        },
    }
</script>
