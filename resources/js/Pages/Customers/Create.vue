<template>
	<Head title="Create Customer" />

    <BreezeAuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Create Customer
          </h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

            	<div class="mt-10 sm:mt-0">
							  <div class="md:grid md:grid-cols-3 md:gap-6">
							    <div class="md:col-span-1">
							      <div class="px-4 sm:px-0">
							        <h3 class="text-lg font-medium leading-6 text-gray-900">Customer Information</h3>
							      </div>
							    </div>
							    <div class="mt-5 md:mt-0 md:col-span-2">
							      <form @submit.prevent="submit">
							        <div class="shadow overflow-hidden sm:rounded-md">
							          <div class="px-4 py-5 bg-white sm:p-6">
							            <div class="grid grid-cols-6 gap-6">
							              
							              <div class="col-span-6 sm:col-span-3">
							                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
							                <input v-model="form.first_name" type="text" name="first_name" id="first_name" autocomplete="given-first_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
							                <span v-if="errors.first_name" v-text="errors.first_name" class="text-red-500 text-sm"></span>
							              </div>              

							              <div class="col-span-6 sm:col-span-3">
							                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
							                <input v-model="form.last_name" type="text" name="last_name" id="last_name" autocomplete="given-last_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
							                <span v-if="errors.last_name" v-text="errors.last_name" class="text-red-500 text-sm"></span>
							              </div>						              

							              
							              

							              <div class="col-span-6 sm:col-span-3">
							                <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
							                <input v-model="form.birth_date" type="text" name="birth_date" id="birth_date" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
							                <span v-if="errors.birth_date" v-text="errors.birth_date" class="text-red-500 text-sm"></span>
							              </div>    


							              <div class="col-span-6 sm:col-span-3">
							                <label for="sales_rep_id" class="block text-sm font-medium text-gray-700">Sales Rep</label>
							                <select v-model="form.sales_rep_id" id="sales_rep_id" name="sales_rep_id" autocomplete="sales-rep-id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							                  <option v-for="user in users" :value="user.id">{{ user.name}}</option>
							                </select>
							                <span v-if="errors.sales_rep_id" v-text="errors.sales_rep_id" class="text-red-500 text-sm"></span>
							              </div>


							              <div class="col-span-6 sm:col-span-3">
							                <label for="company" class="block text-sm font-medium text-gray-700">Companies</label>
							                <select v-model="form.company_id" id="company" name="company" autocomplete="company-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
							                  <option v-for="company in companies" :value="company.id">{{ company.name}}</option>
							                </select>
							                <span v-if="errors.company_id" v-text="errors.company_id" class="text-red-500 text-sm"></span>
							              </div>


							              
							              




							            </div>
							          </div>
							          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
							            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :disabled="form.processing">Save</button>
							          </div>
							        </div>
							      </form>
							    </div>
							  </div>
							</div>

            </div>
          </div>
        </div>
      </div>
    </BreezeAuthenticatedLayout>
</template>

<script>

import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link,useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";

export default {

  name: 'Create',
  props: {
    errors: Object,
    users : Array,
    companies : Array,
  },
  components: {
      BreezeAuthenticatedLayout,
      Head,
      Link,
      useForm,
  },
  data() {
    return {
    	form: this.$inertia.form({
    		first_name : null,
				last_name : null,
				birth_date : null,
				sales_rep_id : null,
				company_id : null
      }),
    };
  },
  methods: {
    submit() {
    	this.form.post(route('customers.store'), {
			  preserveScroll: true,
			  onSuccess: () => this.form.reset(),
			})  
    },
  },
};
</script>
