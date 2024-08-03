<template>
  <div>
    <table class="table">
      <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Login</th>
        <th scope="col">Email</th>
        <th scope="col">Balance</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in users" :key="user.id">
        <th scope="row">{{ user.id }}</th>
        <td>{{ user.name }}</td>
        <td>{{ user.login }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.balance }}</td>
      </tr>
      </tbody>
    </table>
    <nav>
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click="changePage(currentPage - 1)">Previous</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="changePage(currentPage + 1)">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import api from "../api/api";

export default {
  name: "UsersView",
  data() {
    return {
      users: [],
      currentPage: 1,
      totalPages: 0,
      usersPerPage: 5
    }
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers(page = 1) {
      api.get(`api/users?page=${page}`)
          .then((response) => {
            if (response.data.success) {
              this.users = response.data.data.data;
              this.currentPage = response.data.data.current_page;
              this.totalPages = response.data.data.last_page;
            }
          })
          .catch((error) => {
            console.error(error);
            alert(error);
          });
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.fetchUsers(page);
      }
    }
  }
}
</script>

<style scoped>
.pagination {
  display: flex;
  list-style-type: none;
  padding: 0;
}
.page-item {
  margin: 0 5px;
}
.page-link {
  cursor: pointer;
}
.disabled .page-link {
  cursor: not-allowed;
  color: gray;
}
</style>