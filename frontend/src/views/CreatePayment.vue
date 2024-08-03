<template>
  <form>
    <div class="form-group mb-3">
      <label for="details">Details</label>
      <input
          v-model="details"
          type="details"
          class="form-control"
          id="details"
          @input="validateDetails"
          placeholder="Enter details">
      <span v-if="detailsError" class="text-danger">{{ detailsError }}</span>
    </div>
    <div class="form-group mb-3">
      <label for="amount">Amount</label>
      <input
          v-model="amount"
          type="amount"
          class="form-control"
          @input="validateAmount"
          id="amount"
          placeholder="Enter amount">
      <span v-if="amountError" class="text-danger">{{ amountError }}</span>
    </div>
    <div class="form-group mb-3">
      <label style="display: block" for="currency">Currency</label>
      <select class="form-select" v-model="currency" id="currency">
        <option v-for="cur in currencies" :value="cur" :key="cur"> {{cur}} </option>
      </select>
    </div>
    <button
        type="submit"
        class="mt-3 btn btn-primary"
        @click.prevent="createPayment"
    >Create</button>
  </form>
</template>

<script>
import apiSign from "@/api/apiSign";
import router from "@/router";

export default {
  name: "CreatePayment",
  data() {
    return {
      details: '',
      amount: 0,
      currency: 'RUB',
      currencies: [
          'RUB',
          'EUR',
          'USD'
      ],
      detailsError: '',
      amountError: ''
    }
  },
  methods: {
    createPayment() {
      this.validateDetails();
      this.validateAmount();

      if (!this.detailsError && !this.amountError) {
        apiSign.post("api/payments", {
          'details': this.details,
          'amount': this.amount,
          'currency': this.currency,
        })
            .then((response) => {
              if (response.data.success) {
                router.push({ name: "payments" });
              }
            })
            .catch(function (error) {
              console.error(error);
              alert(error)
            });
      }
    },
    validateDetails() {
      const detailsNumber = Number(this.details);
      if (isNaN(detailsNumber) || detailsNumber.toString().length < 13 || detailsNumber.toString().length > 19) {
        this.detailsError = 'Details must be a number with length between 13 and 19.';
      } else {
        this.detailsError = '';
      }
    },
    validateAmount() {
      const amountDecimal = Number(this.amount);
      if (isNaN(amountDecimal) || !this.amount.match(/^\d+(\.\d+)?$/)) {
        this.amountError = 'Amount must be a valid decimal number.';
      } else {
        this.amountError = '';
      }
    },
  }
}
</script>

<style scoped>

</style>