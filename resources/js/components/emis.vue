
<template>
     <div class=" sm:px-4 flex h-full lg:px-0">
        <div class="md:w-1/2 pr-4 pl-4 background-1 h-full pb-0 pt-4">
            <div class="max-w-md mx-auto background-1 px-8 pt-6 pb-8">
                <div class="logo-mb">
                    <img src="../../../public/images/logo.png" alt="" class="logo-height">
                </div>
                <form class="text-white">
                    <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="name">
                        Enter Email
                    </label>
                    <input 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="name" 
                        type="text" 
                        placeholder="Email"
                    >
                    </div>
                    <div class="mb-4">
                    <div class="flex gap-6">
                        <label class="block text-white text-sm font-bold mb-2" for="email">
                        Enter password
                    </label>
                    <a href="3" class="block text-white text-sm font-bold mb-2 dark-white">Forgot password</a>
                    </div>
                    <input  
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="email" 
                        type="email" 
                        placeholder="Password"
                    >
                    </div>
                    
                    <div class="flex items-center justify-between">
                    <button 
                        class="sign-in-btn hover:bg-blue-700 text-white font-bold py-2 px-4 w-64 rounded focus:outline-none focus:shadow-outline" 
                        type="submit"
                    >
                    <i class="mdi mdi-logout"></i>
                        Sign In
                    </button>
                    </div>
                </form>
                <p class="mt-4 text-white new-emis-mb">
                    <strong>
                        New To EMIS?
                    </strong>
                    <a href="#" class="dark-white">Register an account</a>
                </p>
                <div class="flex gap-5 my- text-white">
                    <a href="#" class="dark-white">Terms and conditions</a>
                    <a href="#" class="dark-white">Privacy and policy</a>
                </div>
                <p class="text-white">
                    Copyright © 2024 MoES. All Rights Reserved.
                </p>
            </div>
        </div>
        <div class="md:w-1/2 pr-0 pl-0 flex items-center justify-center h-screen h-100">
            <img src="../../../public/images/login-bg.png" alt="">
        </div>
    </div>
</template>
<style>
.background-1{
    background-color: #004c66;
}

.sign-in-btn{
    background-color: #228eb3;
    width: 20px;
}
.new-emis-mb{
    margin-bottom: 4rem;
}
.logo-mb{
    margin-bottom: 3rem;
}
.dark-white{
    color: #7c8284;
    font-size: 14px;
}
.logo-height{
    height: 4rem;
}
</style>