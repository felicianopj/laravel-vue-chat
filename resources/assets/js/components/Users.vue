<template>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>
            <div v-for="user in userList" class="panel-body">
                {{ user.name }}
            </div>
      </div>
  </div>
</template>

<script>
    export default {
        data: function () {
            return {
                userList: []
            }
        },
        ready: function () {
            this.fetchUsers()
        },
        methods: {
            fetchUsers: function () {
                this.$http.get('api/users').then(function (response) {
                    console.log(response.data)
                    this.userList = response.data
                });
            },
        },
    }
</script>
