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
				Chat messages
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
                });
            },
            chooseUser: function (user) {
                this.user = user
            }
        },
    }
</script>
