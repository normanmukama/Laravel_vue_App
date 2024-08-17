<template>
    <div class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <h2 class="text-2xl mb-4">Contact Form</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Name
          </label>
          <input 
            v-model="form.name" 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            id="name" 
            type="text" 
            placeholder="Name"
          >
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
            Email
          </label>
          <input 
            v-model="form.email" 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            id="email" 
            type="email" 
            placeholder="Email"
          >
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="contact">
            Contact
          </label>
          <input 
            v-model="form.contact" 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            id="contact" 
            type="text" 
            placeholder="Contact"
          >
        </div>
        <div class="flex items-center justify-between">
          <button 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
            type="submit"
          >
            Submit
          </button>
        </div>
      </form>
      <p v-if="message" class="mt-4 text-green-500">{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          contact: ''
        },
        message: ''
      };
    },
    methods: {
      async submitForm() {
        try {
          const response = await axios.post('http://localhost:8000/api/contacts', this.form);
  
          this.message = response.data.message;
          this.form.name = '';
          this.form.email = '';
          this.form.contact = '';
        } catch (error) {
          if (error.response) {
            // Server responded with a status other than 2xx
            console.error("Server responded with an error:", error.response.data);
          } else if (error.request) {
            // Request was made but no response received
            console.error("No response received:", error.request);
          } else {
            // Something else went wrong
            console.error("Error:", error.message);
          }
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* You can add custom styles here */
  </style>
  