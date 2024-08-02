<template>
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <label for="idSearch" class="form-label">ID</label>
        <input v-model="idSearch"
               @change="fetchPayments"
               type="text"
               class="form-control"
               id="idSearch"
               placeholder="Enter ID"
               style="width: 100%;">
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="loginSearch" class="form-label">Login</label>
        <input v-model="loginSearch"
               @change="fetchPayments"
               type="text"
               class="form-control"
               id="loginSearch"
               placeholder="Enter login"
               style="width: 100%;">
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="detailsSearch" class="form-label">Details</label>
        <input v-model="detailsSearch"
               @change="fetchPayments"
               type="text"
               class="form-control"
               id="detailsSearch"
               placeholder="Enter details"
               style="width: 100%;">
      </div>
    </div>
  </div>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Login</th>
      <th scope="col">Details</th>
      <th scope="col">Amount</th>
      <th scope="col">Currency</th>
      <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="payment in payments" :key="payment.id">
      <th scope="row">{{ payment.id }}</th>
      <td>{{ payment.user.login }}</td>
      <td>{{ payment.payload }}</td>
      <td>{{ payment.amount }}</td>
      <td>{{ payment.currency_iso_code }}</td>
      <select class="form-select"
              v-model="payment.status"
              :name="payment.id"
              @change="handleStatusChange"
              :disabled="payment.status === 'paid'">
        <option v-for="status in statuses"
                :value="status"
                :key="status"
        >{{ status }}</option>
      </select>
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
  <router-link
      :to="{ name: 'payment' }"
      type="button"
      class="btn btn-primary"
  >
    Create Payment
  </router-link>
</template>

<script>
import apiSign from "@/api/apiSign";

export default {
  name: "PaymentsView",
  data() {
    return {
      payments: [],
      statuses: [
        'created',
        'paid'
      ],
      idSearch: '',
      detailsSearch: '',
      loginSearch: '',
      currentPage: 1,
      totalPages: 0,
      paymentsPerPage: 5
    }
  },
  created() {
    this.fetchPayments();
  },
  methods: {
    fetchPayments(page = 1) {
      apiSign.get(`http://localhost:8000/api/payments?page=${page}`, {
        params: {
          details: this.detailsSearch,
          id: this.idSearch,
          login: this.loginSearch,
        }
      })
          .then((response) => {
            if (response.data.success) {
              console.log(response.data.data);
              this.payments = response.data.data.data;
              this.currentPage = response.data.data.current_page;
              this.totalPages = response.data.data.last_page;
            }
          })
          .catch(function (error) {
            console.error(error);
            alert(error)
          });
    },
    handleStatusChange(event) {
      const newStatus = event.target.value;
      const id = event.target.name
      this.updatePaymentStatus(id, newStatus);
    },
    updatePaymentStatus(id, newStatus) {
      apiSign.put("http://localhost:8000/api/payments", {
        'id': id,
        'status': newStatus,
      })
          .then((response) => {
            if (response.data.success) {
              console.log(response.data);
            }
          })
          .catch(function (error) {
            console.error(error);
            alert(error)
          });
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.fetchPayments(page);
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