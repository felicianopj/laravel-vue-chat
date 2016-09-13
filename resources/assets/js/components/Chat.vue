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
        <p  v-for="message in messages">
                <span @click="editMessage(message)" v-bind:class="{ 'message-sent': isMessageSent(message), 'message-received': isMessageReceived(message) }">{{ message.content }}</span>
                <span v-if="edit && isMessageSent(message)" @click="deleteMessage(message)" class="delete-button">x</span>
        </p>
        <form action="" method="POST" @submit.prevent="edit ? updateMessage(newMessage.id) : sendMessage()">
            <!-- <input v-if="edit" name="_method" type="hidden" value="PUT"> -->
            <div class="row">
                <div class="col-lg-9">
                    <input v-model="newMessage.content" type="text" name="content" class="form-control" placeholder="Type your message" autofocus>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary form-control send-button">Send</button>
                </div>
            </div>
        </form>
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
                edit: false,
                newMessage: { id: '', sender_id: '', content: ''},
                messages: { sender_id: '', receiver_id: '', content: '', created_at: '' },
            }
        },
        ready: function () {
            this.listen();
            this.fetchUsers();
        },
        methods: {
            listen() {
                Echo.channel('chat.1.messages')
                    .listen('MessageSent', event => {
                        this.messages.push(event.message)
                        this.assignMessages()
                    })
                    .listen('MessageDeleted', event => {
                        this.fetchMessages()
                    })
                    .listen('MessageUpdated', event => {
                        this.fetchMessages()
                    });
            },
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
                this.edit = false
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
            getMessage: function (id) {
                this.$http.get('api/message/' + id).then(function (response) {
                    this.newMessage.id = response.data.id
                    this.newMessage.sender_id = response.data.sender_id
                    this.newMessage.content = response.data.content
                });
            },
            sendMessage: function () {
                this.$http.post('api/message', { 'sender_id': this.authUser.id, 'receiver_id': this.user.id, 'content': this.newMessage.content }).then( function (response) {
                    this.fetchMessages()
                    this.emptyNewMessage()
                });
            },
            updateMessage: function (id) {
                this.$http.patch('api/message/' + id, { 'sender_id': this.authUser.id, 'content': this.newMessage.content }).then(function (response) {
                    this.fetchUsers()
                    this.emptyNewMessage()
                    this.edit = false
                });
            },
            deleteMessage: function (message) {
                if (this.isMessageSent(message)) {
                    this.$http.delete('api/message/' + message.id).then(function (response) {
                        console.log(response.body)
                        this.fetchMessages()
                        this.emptyNewMessage()
                    });
                }
            },
            editMessage: function (message) {
                if (this.isMessageSent(message)) {
                    this.edit = true
                    this.getMessage(message.id)
                }
            },
            isMessageSent: function (message) {
                return this.authUser.id == message.sender_id
            },
            isMessageReceived: function (message) {
                return this.authUser.id == message.receiver_id
            },
            emptyNewMessage: function () {
                this.newMessage.id = ''
                this.newMessage.sender_id = ''
                this.newMessage.content = ''
            },
        },
    }
</script>
