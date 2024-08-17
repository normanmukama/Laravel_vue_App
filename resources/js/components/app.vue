<template>
  <div>
        <nav class="bg-gray-800 text-white py-4 px-6">
          <!-- Desktop Navigation -->
          <div class="hidden lg:flex justify-between items-center">
            <div class="flex space-x-4">
              <router-link to="/" class="nav-item">Home</router-link>
              <router-link to="/about" class="nav-item">About</router-link>
              <router-link to="/service" class="nav-item">Services</router-link>
              <router-link to="/location" class="nav-item">Contacts</router-link>
              <router-link to="/contact" class="nav-item">Form</router-link>
              <router-link to="/emis" class="nav-item">EMIS</router-link>
            </div>
            <div>
              <!-- Add any additional items like a logo or a search bar here -->
            </div>
          </div>

          <!-- Mobile Navigation -->
          <div class="lg:hidden flex items-center justify-between">
            <div class="text-xl font-bold">Brand</div>
            <button @click="toggleMenu" class="text-white focus:outline-none">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
          </div>

          <!-- Mobile Menu -->
          <div v-if="isMenuOpen" class="lg:hidden bg-gray-700 mt-2 rounded-md">
            <router-link to="/" class="block px-4 py-2 text-white hover:bg-gray-600">Home</router-link>
            <router-link to="/about" class="block px-4 py-2 text-white hover:bg-gray-600">About</router-link>
            <router-link to="/services" class="block px-4 py-2 text-white hover:bg-gray-600">Services</router-link>
            <router-link to="/location" class="block px-4 py-2 text-white hover:bg-gray-600">Location</router-link>
            <router-link to="/contact" class="block px-4 py-2 text-white hover:bg-gray-600">Contact</router-link>
          </div>
        </nav>

        <main>
          <router-view/>
        </main>
  </div>
</template>

<script>

</script>

<style scoped>
.nav-item {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem; /* Rounded corners */
  transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-item:hover {
  background-color: #2563eb; /* Blue color */
  color: #ffffff;
}
</style>

  
  