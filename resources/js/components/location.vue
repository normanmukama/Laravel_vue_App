<template>
  <div class="p-4 bg-gray-100">
    <div class="flex justify-between mb-4">
      <input
        v-model="searchQuery"
        @input="applyFilter"
        type="text"
        placeholder="Search..."
        class="p-2 border border-green-500 rounded"
      />
      <div>
        <button @click="exportToExcel" class="p-2 bg-green-500 text-white rounded">Excel</button>
        <button @click="exportToCSV" class="p-2 bg-blue-500 text-white rounded ml-2">CSV</button>
        <button @click="exportToPDF" class="p-2 bg-red-500 text-white rounded ml-2">PDF</button>
      </div>
    </div>

    <!-- Manually rendering the table -->
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th
            v-for="column in cols"
            :key="column.field"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            {{ column.title }}
          </th>
          <!-- Actions column header -->
          <th class="px-3 py-0 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Actions
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="row in paginatedContacts" :key="row.id" class="hover:bg-gray-100">
          <td
            v-for="column in cols"
            :key="column.field"
            class="px-3 py whitespace-nowrap text-sm text-gray-900"
          >
            {{ row[column.field] }}
          </td>
          <!-- Actions buttons -->
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <button @click="viewContact(row)" class="px-2 py-1 text-white bg-blue-500 rounded mx-1">View</button>
            <!-- <button @click="editContact(row)" class="px-2 py-1 text-white bg-yellow-500 rounded mx-1">Edit</button> -->
            <button @click="editContact(row)" class="px-2 py-1 text-white bg-yellow-500 rounded mx-1">Edit</button>
            <button @click="deleteContact(row)" class="px-2 py-1 text-white bg-red-500 rounded mx-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="flex justify-evenly mt-4">
      <button
        @click="previousPage"
        :disabled="currentPage === 1"
        class="p-2 bg-gray-300 text-gray-600 rounded"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="p-2 bg-gray-300 text-gray-600 rounded"
      >
        Next
      </button>
    </div>
  </div>


  <!-- Edit modal -->
  <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-sm mx-4">
      <h2 class="text-xl font-bold mb-4">Edit Contact</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Name</label>
          <input v-model="selectedContact.name" id="name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input v-model="selectedContact.email" id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" />
        </div>
        <div class="mb-4">
          <label for="contact" class="block text-gray-700">Contact</label>
          <input v-model="selectedContact.contact" id="contact" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" />
        </div>
        <div class="flex justify-between">
          <button @click="cancel" type="button" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import * as XLSX from 'xlsx';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

// State management
const contacts = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const pageSize = ref(6);
const showModal = ref(false);
const selectedContact = ref(null);

// Columns for export
const cols = ref([
  { field: 'id', title: 'ID', width: '90px', filter: false },
  { field: 'name', title: 'Name' },
  { field: 'email', title: 'Email' },
  { field: 'contact', title: 'Contact' },
  { field: 'created_at', title: 'Datehire' },
  { field: 'updated_at', title: 'Last Updated' }
]);

// Computed properties
const filteredContacts = computed(() => {
  if (!searchQuery.value) return contacts.value;
  return contacts.value.filter(contact => 
    Object.values(contact).some(val => 
      String(val).toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  );
});

const paginatedContacts = computed(() => {
  const start = (currentPage.value - 1) * pageSize.value;
  const end = start + pageSize.value;
  return filteredContacts.value.slice(start, end);
});

const totalPages = computed(() => {
  return Math.ceil(filteredContacts.value.length / pageSize.value);
});

// Methods
function previousPage() {
  if (currentPage.value > 1) {
    currentPage.value -= 1;
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1;
  }
}

async function fetchContacts() {
  try {
    const response = await axios.get('http://localhost:8000/api/get-contacts');
    contacts.value = response.data;
  } catch (error) {
    console.error('Error fetching contacts:', error);
  }
}

function applyFilter() {
  currentPage.value = 1; // Reset to the first page on search
}

function exportToExcel() {
  const ws = XLSX.utils.json_to_sheet(contacts.value);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Contacts');
  XLSX.writeFile(wb, 'contacts.xlsx');
}

function exportToCSV() {
  const ws = XLSX.utils.json_to_sheet(contacts.value);
  const csv = XLSX.utils.sheet_to_csv(ws);
  const blob = new Blob([csv], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'contacts.csv';
  a.click();
  window.URL.revokeObjectURL(url);
}

function exportToPDF() {
  const doc = new jsPDF();
  doc.autoTable({
    head: [cols.value.map(col => col.title)],
    body: contacts.value.map(contact => cols.value.map(col => contact[col.field])),
  });
  doc.save('contacts.pdf');
}

function viewContact(contact) {
  alert(`Viewing contact: ${contact.name}`);
  // Implement the logic for viewing a contact
}

async function editContact(contact) {
  selectedContact.value = { ...contact }; // Create a copy to avoid mutating the original
  showModal.value = true;
}

async function deleteContact(contact) {
  if (confirm(`Are you sure you want to delete contact: ${contact.name}?`)) {
    try {
      await axios.delete(`http://localhost:8000/api/delete-contact/${contact.id}`);
      contacts.value = contacts.value.filter(c => c.id !== contact.id);
    } catch (error) {
      console.error('Error deleting contact:', error);
    }
  }
}

async function submitForm() {
  try {
    const response = await axios.put(`http://localhost:8000/api/update-contact/${selectedContact.value.id}`, selectedContact.value);
    // Update the contact in the contacts array
    const index = contacts.value.findIndex(c => c.id === response.data.id);
    if (index !== -1) {
      contacts.value[index] = response.data;
    }
    showModal.value = false;
  } catch (error) {
    console.error('Error updating contact:', error);
  }
}

function cancel() {
  showModal.value = false;
}

// Fetch contacts on component mount
fetchContacts();
</script>

<style scoped>

</style>
