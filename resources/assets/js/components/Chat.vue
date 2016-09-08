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
				<strong>Sent Messages</strong>
                <p v-for="message in sentMessages">{{ message.content }}</p>
                <br>
                <strong>Received Messages</strong>
                <p v-for="message in receivedMessages">{{ message.content }}</p>
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
                sentMessages: [],
                receivedMessages: []
    		}
    	},
        ready: function () {
            this.fetchAuthUser()
            this.fetchUsers()
        },
        methods: {
            fetchUsers: function () {
                this.$http.get('api/users').then(function (response) {
                    this.userList = response.data
                    this.user = response.data[0]
                    this.fetchSentMessages()
                    this.fetchReceivedMessages()
                });
            },
            fetchAuthUser: function () {
                this.$http.get('api/auth-user').then(function (response) {
                    this.authUser = response.data
                });
            },
            fetchSentMessages: function () {
                this.$http.get('api/sender-messages/' + this.user.id).then(function (response) {
                    this.sentMessages = response.data
                });
            },
            fetchReceivedMessages: function () {
            	this.$http.get('api/receiver-messages/' + this.user.id).then(function (response) {
                    this.receivedMessages = response.data
                });
            },
            chooseUser: function (user) {
                this.user = user
                this.fetchSentMessages(this.user)
            	this.fetchReceivedMessages(this.user)
            }
        },
    }
</script>
